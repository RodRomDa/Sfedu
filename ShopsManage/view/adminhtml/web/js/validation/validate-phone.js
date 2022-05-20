define([
    'jquery',
    'mage/translate'
], function($) {
    'use strict';

    return function (validator) {
        validator.addRule(
            'validate-phone',
            function(value, element) {
                return /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/.test(value);
            },
            $.mage.__('Please enter a valid phone number. For example 89505326690 or +79505326690 or (951)-532-6690.')
        )
        return validator;
    }
});
