$(function () {
    $('table').tableShrinker({
        useTransitions: true,
        transitionSpeed: 300,
        customToggle: ["<span><i class=\"bi bi-chevron-compact-down\"></i></span>", "<span><i class=\"bi bi-chevron-compact-up\"></i></span>"],
        customToggleAll: ["<span><i class=\"bi bi-chevron-compact-down\"></i></span>", "<span><i class=\"bi bi-chevron-compact-up\"></i></span>"],
        showToggle: true,
        showToggleAll: true,
        iconsOnLeft: false
    })
})