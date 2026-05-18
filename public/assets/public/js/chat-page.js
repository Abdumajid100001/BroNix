(function () {
  "use strict";

  const root = document.querySelector("[data-chat-page]");

  if (!root) {
    return;
  }

  const endpoint = root.dataset.endpoint;
  const storageKey = root.dataset.storageKey || "bronix-chat-page-history";
  const loadingText = root.dataset.loadingText || "Loading...";
  const errorText = root.dataset.errorText || "Error";
  const introText = root.dataset.introText || "";
  const initialPrompt = (root.dataset.initialPrompt || "").trim();
  const form = root.querySelector("[data-chat-form]");
  const input = root.querySelector("[data-chat-input]");
  const messages = root.querySelector("[data-chat-messages]");
  const submit = root.querySelector("[data-chat-submit]");
  const promptButtons = root.querySelectorAll("[data-chat-prompt]");

  let history = loadHistory();
  let busy = false;

  restoreHistory();
  autoResize();

  if (!history.length && introText) {
    appendMessage("assistant", introText);
  }

  if (initialPrompt) {
    window.setTimeout(() => {
      send(initialPrompt);
      clearPromptFromUrl();
    }, 0);
  }

  form?.addEventListener("submit", (event) => {
    event.preventDefault();
    send(input?.value || "");
  });

  input?.addEventListener("input", autoResize);
  input?.addEventListener("keydown", (event) => {
    if (event.key === "Enter" && !event.shiftKey) {
      event.preventDefault();
      send(input?.value || "");
    }
  });

  promptButtons.forEach((button) => {
    button.addEventListener("click", () => {
      const prompt = button.getAttribute("data-chat-prompt");

      if (!prompt) {
        return;
      }

      send(prompt);
    });
  });

  function loadHistory() {
    try {
      const parsed = JSON.parse(localStorage.getItem(storageKey) || "[]");
      return Array.isArray(parsed) ? parsed : [];
    } catch (error) {
      return [];
    }
  }

  function saveHistory() {
    localStorage.setItem(storageKey, JSON.stringify(history.slice(-20)));
  }

  function restoreHistory() {
    if (!history.length || !messages) {
      return;
    }

    messages.innerHTML = "";
    history.forEach((item) => appendMessage(item.role, item.content));
  }

  function clearPromptFromUrl() {
    if (!window.history.replaceState) {
      return;
    }

    const url = new URL(window.location.href);
    url.searchParams.delete("prompt");
    window.history.replaceState({}, document.title, url.toString());
  }

  function autoResize() {
    if (!input) {
      return;
    }

    input.style.height = "auto";
    input.style.height = Math.min(input.scrollHeight, 180) + "px";
  }

  function setBusyState(value) {
    busy = value;

    if (submit) {
      submit.disabled = value;
    }

    root.classList.toggle("is-busy", value);
  }

  function appendMessage(role, content, options) {
    if (!messages) {
      return null;
    }

    const article = document.createElement("article");
    article.className = "bnx-chat-message is-" + role + (options?.loading ? " is-loading" : "");

    const bubble = document.createElement("div");
    bubble.className = "bnx-chat-message__bubble";
    bubble.textContent = content;

    article.appendChild(bubble);
    messages.appendChild(article);
    messages.scrollTop = messages.scrollHeight;

    return article;
  }

  function removeMessage(node) {
    if (node && node.parentNode) {
      node.parentNode.removeChild(node);
    }
  }

  async function send(rawMessage) {
    const message = rawMessage.trim();

    if (!message || !endpoint || busy) {
      return;
    }

    setBusyState(true);
    appendMessage("user", message);
    history.push({ role: "user", content: message });
    saveHistory();

    if (input) {
      input.value = "";
      autoResize();
      input.focus();
    }

    const loadingNode = appendMessage("assistant", loadingText, { loading: true });

    try {
      const response = await fetch(endpoint, {
        method: "POST",
        headers: {
          Accept: "application/json",
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')?.getAttribute("content") || "",
        },
        body: JSON.stringify({ message }),
      });

      const payload = await response.json();

      removeMessage(loadingNode);

      if (!response.ok) {
        appendMessage("assistant", payload.reply || errorText);
        return;
      }

      const reply = payload.reply || errorText;
      appendMessage("assistant", reply);
      history.push({ role: "assistant", content: reply });
      saveHistory();
    } catch (error) {
      removeMessage(loadingNode);
      appendMessage("assistant", errorText);
    } finally {
      setBusyState(false);
    }
  }
})();
