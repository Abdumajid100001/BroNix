@php
    $assistantExamples = [
        __('messages.prompts.barbershop_budget'),
        __('messages.prompts.popular_salons'),
        __('messages.prompts.good_schedule'),
    ];
@endphp

<div
    class="bnx-assistant-widget"
    data-bnx-assistant
    data-endpoint="{{ route('assistant.message') }}"
    data-storage-key="bronix-assistant-history"
    data-loading-text="{{ __('messages.chat.loading') }}"
    data-error-text="{{ __('messages.chat.error') }}"
>
    <button type="button" class="bnx-assistant-widget__toggle" data-bnx-assistant-toggle aria-expanded="false">
        <span class="bnx-assistant-widget__dot"></span>
        <span>{{ __('messages.chat.button') }}</span>
        <i class="bi bi-stars"></i>
    </button>

    <section class="bnx-assistant-widget__panel" data-bnx-assistant-panel aria-hidden="true">
        <header class="bnx-assistant-widget__header">
            <div>
                <strong>{{ __('messages.chat.title') }}</strong>
                <p>{{ __('messages.chat.description') }}</p>
            </div>
            <button type="button" class="bnx-assistant-widget__close" data-bnx-assistant-close aria-label="{{ __('messages.chat.close') }}">
                <i class="bi bi-x-lg"></i>
            </button>
        </header>

        <div class="bnx-assistant-widget__messages" data-bnx-assistant-messages>
            <article class="bnx-chat-message is-assistant">
                <div class="bnx-chat-message__bubble">
                    {{ __('messages.chat.intro') }}
                </div>
            </article>
        </div>

        <div class="bnx-assistant-widget__prompts">
            @foreach($assistantExamples as $example)
                <button type="button" class="bnx-chip" data-bnx-prompt="{{ $example }}">{{ $example }}</button>
            @endforeach
        </div>

        <form class="bnx-assistant-widget__form" data-bnx-assistant-form>
            <label class="visually-hidden" for="bnx-assistant-input">{{ __('messages.chat.input_label') }}</label>
            <textarea
                id="bnx-assistant-input"
                rows="1"
                maxlength="800"
                data-bnx-assistant-input
                placeholder="{{ __('messages.chat.placeholder') }}"
            ></textarea>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-send"></i>
            </button>
        </form>
    </section>
</div>
