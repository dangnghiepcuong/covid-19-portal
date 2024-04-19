window.trans = function (key, replace = {}) {
    let lang = $('html').attr('lang')
    if (!lang) {
        lang = 'en'
    }

    let translation = key.split('.').reduce((t, i) => t[i] || null, window.translations[lang]);

    for (var placeholder in replace) {
        translation = translation.replace(`:${placeholder}`, replace[placeholder]);
    }

    return translation;
}
