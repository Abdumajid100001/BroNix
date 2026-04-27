(function () {
  "use strict";

  const root = document.querySelector("[data-bnx-assistant]");

  if (!root) {
    return;
  }

  const endpoint = root.dataset.endpoint;
  const storageKey = root.dataset.storageKey || "bronix-assistant-history";
  const toggle = root.querySelector("[data-bnx-assistant-toggle]");
  const close = root.querySelector("[data-bnx-assistant-close]");
  const panel = root.querySelector("[data-bnx-assistant-panel]");
  const form = root.querySelector("[data-bnx-assistant-form]");
  const input = root.querySelector("[data-bnx-assistant-input]");
  const messages = root.querySelector("[data-bnx-assistant-messages]");
  const promptButtons = document.querySelectorAll("[data-bnx-prompt]");
  const openButtons = document.querySelectorAll("[data-bnx-open-assistant]");

  let history = loadHistory();
  let busy = false;

  restoreHistory();
  autoResize();

  toggle?.addEventListener("click", () => setOpen(!root.classList.contains("is-open")));
  close?.addEventListener("click", () => setOpen(false));

  openButtons.forEach((button) => {
    button.addEventListener("click", (event) => {
      event.preventDefault();
      setOpen(true);
      input?.focus();
    });
  });

  promptButtons.forEach((button) => {
    button.addEventListener("click", () => {
      const prompt = button.getAttribute("data-bnx-prompt");

      if (!prompt) {
        return;
      }

      setOpen(true);
      send(prompt);
    });
  });

  input?.addEventListener("input", autoResize);

  form?.addEventListener("submit", (event) => {
    event.preventDefault();
    send(input?.value || "");
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
    localStorage.setItem(storageKey, JSON.stringify(history.slice(-8)));
  }

  function restoreHistory() {
    if (!history.length) {
      return;
    }

    messages.innerHTML = "";
    history.forEach((item) => appendMessage(item.role, item.content));
  }

  function autoResize() {
    if (!input) {
      return;
    }

    input.style.height = "auto";
    input.style.height = Math.min(input.scrollHeight, 120) + "px";
  }

  function setOpen(isOpen) {
    root.classList.toggle("is-open", isOpen);
    panel?.setAttribute("aria-hidden", String(!isOpen));
    toggle?.setAttribute("aria-expanded", String(isOpen));

    if (isOpen) {
      scrollToBottom();
    }
  }

  function appendMessage(role, content, options = {}) {
    const article = document.createElement("article");
    article.className = "bnx-chat-message is-" + role + (options.loading ? " is-loading" : "");

    const bubble = document.createElement("div");
    bubble.className = "bnx-chat-message__bubble";
    bubble.textContent = content;
    article.appendChild(bubble);

    if (Array.isArray(options.recommendations) && options.recommendations.length) {
      const cards = document.createElement("div");
      cards.className = "bnx-chat-recommendations";

      options.recommendations.forEach((item) => {
        const card = document.createElement("article");
        card.className = "bnx-chat-card";

        const image = document.createElement("img");
        image.className = "bnx-chat-card__image";
        image.src = item.image;
        image.alt = item.name;

        const body = document.createElement("div");
        body.className = "bnx-chat-card__body";

        const title = document.createElement("h4");
        title.textContent = item.name;

        const meta = document.createElement("div");
        meta.className = "bnx-chat-card__meta";
        [item.type, item.price, item.schedule].forEach((value) => {
          const span = document.createElement("span");
          span.textContent = value;
          meta.appendChild(span);
        });

        const description = document.createElement("p");
        description.textContent = item.description;

        const reason = document.createElement("p");
        reason.className = "bnx-chat-card__reason";
        reason.textContent = item.reason;

        const link = document.createElement("a");
        link.className = "btn btn-primary";
        link.href = item.link;
        link.textContent = "К бронированию";

        body.append(title, meta, description, reason, link);
        card.append(image, body);
        cards.appendChild(card);
      });

      article.appendChild(cards);
    }

    messages.appendChild(article);
    scrollToBottom();

    return article;
  }

  function removeMessage(node) {
    if (node && node.parentNode) {
      node.parentNode.removeChild(node);
    }
  }

  function scrollToBottom() {
    messages.scrollTop = messages.scrollHeight;
  }

  async function send(rawMessage) {
    const message = rawMessage.trim();

    if (!message || busy || !endpoint) {
      return;
    }

    busy = true;
    appendMessage("user", message);
    history.push({ role: "user", content: message });
    saveHistory();

    if (input) {
      input.value = "";
      autoResize();
      input.focus();
    }

    const loadingNode = appendMessage("assistant", "Подбираю и сравниваю бизнесы...", { loading: true });

    try {
      const response = await fetch(endpoint, {
        method: "POST",
        headers: {
          Accept: "application/json",
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')?.getAttribute("content") || "",
        },
        body: JSON.stringify({
          message,
          history: history.slice(-6),
        }),
      });

      if (!response.ok) {
        throw new Error("Request failed");
      }

      const payload = await response.json();
      removeMessage(loadingNode);
      appendMessage("assistant", payload.answer || "Не удалось сформировать ответ.", {
        recommendations: payload.recommendations || [],
      });

      history.push({
        role: "assistant",
        content: payload.answer || "",
      });
      saveHistory();
    } catch (error) {
      removeMessage(loadingNode);
      appendMessage("assistant", "Не удалось получить ответ. Проверьте данные каталога и попробуйте ещё раз.");
    } finally {
      busy = false;
    }
  }
})();
