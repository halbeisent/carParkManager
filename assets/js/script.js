$(document).ready(function () {
    $('.sidenav').sidenav();
    $('.parallax').parallax();
    $('.dropdown-trigger').dropdown();
    $('select').formSelect();
    $('.datepicker').datepicker({
        format: 'dd/mm/yyyy',
        i18n: {
            months: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
            monthsShort: ['Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Juin', 'Jui', 'Août', 'Sept', 'Oct', 'Nov', 'Dec'],
            weekDays: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
            weekDaysShort: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
            weekDaysAbbrev: ['D', 'L', 'M', 'M', 'J', 'V', 'S']
        }
    });
    $('.slider').slider();
    $('.modal').modal();
    $('.fixed-action-btn').floatingActionButton({
        direction: 'left',
        hoverEnabled: false
    });
});