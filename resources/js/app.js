let activeConvertForm = null;
let resetTimer = null;

function resetConvertForm(form) {
    if (!form) {
        return;
    }

    const button = form.querySelector('[data-submit-button]');
    const defaultText = form.querySelector('[data-default-text]');
    const loadingText = form.querySelector('[data-loading-text]');

    if (button) {
        button.disabled = false;
    }

    if (defaultText) {
        defaultText.classList.remove('hidden');
    }

    if (loadingText) {
        loadingText.classList.add('hidden');
    }
}

window.handleConvertSubmit = function (form) {
    const button = form.querySelector('[data-submit-button]');
    const defaultText = form.querySelector('[data-default-text]');
    const loadingText = form.querySelector('[data-loading-text]');

    if (!button || button.disabled) {
        return false;
    }

    activeConvertForm = form;

    button.disabled = true;

    if (defaultText) {
        defaultText.classList.add('hidden');
    }

    if (loadingText) {
        loadingText.classList.remove('hidden');
    }

    if (resetTimer) {
        clearTimeout(resetTimer);
    }

    resetTimer = setTimeout(() => {
        resetConvertForm(activeConvertForm);
        activeConvertForm = null;
    }, 15000);

    return true;
};

window.addEventListener('focus', () => {
    if (activeConvertForm) {
        resetConvertForm(activeConvertForm);
        activeConvertForm = null;
    }
});

window.addEventListener('pageshow', () => {
    if (activeConvertForm) {
        resetConvertForm(activeConvertForm);
        activeConvertForm = null;
    }
});