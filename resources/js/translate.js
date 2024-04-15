window.trans = function (key, replace = {}) {
    let translation = key.split('.').reduce((t, i) => t[i] || null, window.translations[window.lang]);

    for (var placeholder in replace) {
        translation = translation.replace(`:${placeholder}`, replace[placeholder]);
    }

    return translation;
}
