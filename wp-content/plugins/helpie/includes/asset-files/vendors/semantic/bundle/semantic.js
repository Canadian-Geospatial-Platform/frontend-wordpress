 /*
 * # Semantic UI - 2.4.2
 * https://github.com/Semantic-Org/Semantic-UI
 * http://www.semantic-ui.com/
 *
 * Copyright 2014 Contributors
 * Released under the MIT license
 * http://opensource.org/licenses/MIT
 *
 */
/*!
 * # Semantic UI 2.4.2 - Checkbox
 * http://github.com/semantic-org/semantic-ui/
 *
 *
 * Released under the MIT license
 * http://opensource.org/licenses/MIT
 *
 */

;(function ($, window, document, undefined) {

'use strict';

window = (typeof window != 'undefined' && window.Math == Math)
  ? window
  : (typeof self != 'undefined' && self.Math == Math)
    ? self
    : Function('return this')()
;

$.fn.checkbox = function(parameters) {
  var
    $allModules    = $(this),
    moduleSelector = $allModules.selector || '',

    time           = new Date().getTime(),
    performance    = [],

    query          = arguments[0],
    methodInvoked  = (typeof query == 'string'),
    queryArguments = [].slice.call(arguments, 1),
    returnedValue
  ;

  $allModules
    .each(function() {
      var
        settings        = $.extend(true, {}, $.fn.checkbox.settings, parameters),

        className       = settings.className,
        namespace       = settings.namespace,
        selector        = settings.selector,
        error           = settings.error,

        eventNamespace  = '.' + namespace,
        moduleNamespace = 'module-' + namespace,

        $module         = $(this),
        $label          = $(this).children(selector.label),
        $input          = $(this).children(selector.input),
        input           = $input[0],

        initialLoad     = false,
        shortcutPressed = false,
        instance        = $module.data(moduleNamespace),

        observer,
        element         = this,
        module
      ;

      module      = {

        initialize: function() {
          module.verbose('Initializing checkbox', settings);

          module.create.label();
          module.bind.events();

          module.set.tabbable();
          module.hide.input();

          module.observeChanges();
          module.instantiate();
          module.setup();
        },

        instantiate: function() {
          module.verbose('Storing instance of module', module);
          instance = module;
          $module
            .data(moduleNamespace, module)
          ;
        },

        destroy: function() {
          module.verbose('Destroying module');
          module.unbind.events();
          module.show.input();
          $module.removeData(moduleNamespace);
        },

        fix: {
          reference: function() {
            if( $module.is(selector.input) ) {
              module.debug('Behavior called on <input> adjusting invoked element');
              $module = $module.closest(selector.checkbox);
              module.refresh();
            }
          }
        },

        setup: function() {
          module.set.initialLoad();
          if( module.is.indeterminate() ) {
            module.debug('Initial value is indeterminate');
            module.indeterminate();
          }
          else if( module.is.checked() ) {
            module.debug('Initial value is checked');
            module.check();
          }
          else {
            module.debug('Initial value is unchecked');
            module.uncheck();
          }
          module.remove.initialLoad();
        },

        refresh: function() {
          $label = $module.children(selector.label);
          $input = $module.children(selector.input);
          input  = $input[0];
        },

        hide: {
          input: function() {
            module.verbose('Modifying <input> z-index to be unselectable');
            $input.addClass(className.hidden);
          }
        },
        show: {
          input: function() {
            module.verbose('Modifying <input> z-index to be selectable');
            $input.removeClass(className.hidden);
          }
        },

        observeChanges: function() {
          if('MutationObserver' in window) {
            observer = new MutationObserver(function(mutations) {
              module.debug('DOM tree modified, updating selector cache');
              module.refresh();
            });
            observer.observe(element, {
              childList : true,
              subtree   : true
            });
            module.debug('Setting up mutation observer', observer);
          }
        },

        attachEvents: function(selector, event) {
          var
            $element = $(selector)
          ;
          event = $.isFunction(module[event])
            ? module[event]
            : module.toggle
          ;
          if($element.length > 0) {
            module.debug('Attaching checkbox events to element', selector, event);
            $element
              .on('click' + eventNamespace, event)
            ;
          }
          else {
            module.error(error.notFound);
          }
        },

        event: {
          click: function(event) {
            var
              $target = $(event.target)
            ;
            if( $target.is(selector.input) ) {
              module.verbose('Using default check action on initialized checkbox');
              return;
            }
            if( $target.is(selector.link) ) {
              module.debug('Clicking link inside checkbox, skipping toggle');
              return;
            }
            module.toggle();
            $input.focus();
            event.preventDefault();
          },
          keydown: function(event) {
            var
              key     = event.which,
              keyCode = {
                enter  : 13,
                space  : 32,
                escape : 27
              }
            ;
            if(key == keyCode.escape) {
              module.verbose('Escape key pressed blurring field');
              $input.blur();
              shortcutPressed = true;
            }
            else if(!event.ctrlKey && ( key == keyCode.space || key == keyCode.enter) ) {
              module.verbose('Enter/space key pressed, toggling checkbox');
              module.toggle();
              shortcutPressed = true;
            }
            else {
              shortcutPressed = false;
            }
          },
          keyup: function(event) {
            if(shortcutPressed) {
              event.preventDefault();
            }
          }
        },

        check: function() {
          if( !module.should.allowCheck() ) {
            return;
          }
          module.debug('Checking checkbox', $input);
          module.set.checked();
          if( !module.should.ignoreCallbacks() ) {
            settings.onChecked.call(input);
            settings.onChange.call(input);
          }
        },

        uncheck: function() {
          if( !module.should.allowUncheck() ) {
            return;
          }
          module.debug('Unchecking checkbox');
          module.set.unchecked();
          if( !module.should.ignoreCallbacks() ) {
            settings.onUnchecked.call(input);
            settings.onChange.call(input);
          }
        },

        indeterminate: function() {
          if( module.should.allowIndeterminate() ) {
            module.debug('Checkbox is already indeterminate');
            return;
          }
          module.debug('Making checkbox indeterminate');
          module.set.indeterminate();
          if( !module.should.ignoreCallbacks() ) {
            settings.onIndeterminate.call(input);
            settings.onChange.call(input);
          }
        },

        determinate: function() {
          if( module.should.allowDeterminate() ) {
            module.debug('Checkbox is already determinate');
            return;
          }
          module.debug('Making checkbox determinate');
          module.set.determinate();
          if( !module.should.ignoreCallbacks() ) {
            settings.onDeterminate.call(input);
            settings.onChange.call(input);
          }
        },

        enable: function() {
          if( module.is.enabled() ) {
            module.debug('Checkbox is already enabled');
            return;
          }
          module.debug('Enabling checkbox');
          module.set.enabled();
          settings.onEnable.call(input);
          // preserve legacy callbacks
          settings.onEnabled.call(input);
        },

        disable: function() {
          if( module.is.disabled() ) {
            module.debug('Checkbox is already disabled');
            return;
          }
          module.debug('Disabling checkbox');
          module.set.disabled();
          settings.onDisable.call(input);
          // preserve legacy callbacks
          settings.onDisabled.call(input);
        },

        get: {
          radios: function() {
            var
              name = module.get.name()
            ;
            return $('input[name="' + name + '"]').closest(selector.checkbox);
          },
          otherRadios: function() {
            return module.get.radios().not($module);
          },
          name: function() {
            return $input.attr('name');
          }
        },

        is: {
          initialLoad: function() {
            return initialLoad;
          },
          radio: function() {
            return ($input.hasClass(className.radio) || $input.attr('type') == 'radio');
          },
          indeterminate: function() {
            return $input.prop('indeterminate') !== undefined && $input.prop('indeterminate');
          },
          checked: function() {
            return $input.prop('checked') !== undefined && $input.prop('checked');
          },
          disabled: function() {
            return $input.prop('disabled') !== undefined && $input.prop('disabled');
          },
          enabled: function() {
            return !module.is.disabled();
          },
          determinate: function() {
            return !module.is.indeterminate();
          },
          unchecked: function() {
            return !module.is.checked();
          }
        },

        should: {
          allowCheck: function() {
            if(module.is.determinate() && module.is.checked() && !module.should.forceCallbacks() ) {
              module.debug('Should not allow check, checkbox is already checked');
              return false;
            }
            if(settings.beforeChecked.apply(input) === false) {
              module.debug('Should not allow check, beforeChecked cancelled');
              return false;
            }
            return true;
          },
          allowUncheck: function() {
            if(module.is.determinate() && module.is.unchecked() && !module.should.forceCallbacks() ) {
              module.debug('Should not allow uncheck, checkbox is already unchecked');
              return false;
            }
            if(settings.beforeUnchecked.apply(input) === false) {
              module.debug('Should not allow uncheck, beforeUnchecked cancelled');
              return false;
            }
            return true;
          },
          allowIndeterminate: function() {
            if(module.is.indeterminate() && !module.should.forceCallbacks() ) {
              module.debug('Should not allow indeterminate, checkbox is already indeterminate');
              return false;
            }
            if(settings.beforeIndeterminate.apply(input) === false) {
              module.debug('Should not allow indeterminate, beforeIndeterminate cancelled');
              return false;
            }
            return true;
          },
          allowDeterminate: function() {
            if(module.is.determinate() && !module.should.forceCallbacks() ) {
              module.debug('Should not allow determinate, checkbox is already determinate');
              return false;
            }
            if(settings.beforeDeterminate.apply(input) === false) {
              module.debug('Should not allow determinate, beforeDeterminate cancelled');
              return false;
            }
            return true;
          },
          forceCallbacks: function() {
            return (module.is.initialLoad() && settings.fireOnInit);
          },
          ignoreCallbacks: function() {
            return (initialLoad && !settings.fireOnInit);
          }
        },

        can: {
          change: function() {
            return !( $module.hasClass(className.disabled) || $module.hasClass(className.readOnly) || $input.prop('disabled') || $input.prop('readonly') );
          },
          uncheck: function() {
            return (typeof settings.uncheckable === 'boolean')
              ? settings.uncheckable
              : !module.is.radio()
            ;
          }
        },

        set: {
          initialLoad: function() {
            initialLoad = true;
          },
          checked: function() {
            module.verbose('Setting class to checked');
            $module
              .removeClass(className.indeterminate)
              .addClass(className.checked)
            ;
            if( module.is.radio() ) {
              module.uncheckOthers();
            }
            if(!module.is.indeterminate() && module.is.checked()) {
              module.debug('Input is already checked, skipping input property change');
              return;
            }
            module.verbose('Setting state to checked', input);
            $input
              .prop('indeterminate', false)
              .prop('checked', true)
            ;
            module.trigger.change();
          },
          unchecked: function() {
            module.verbose('Removing checked class');
            $module
              .removeClass(className.indeterminate)
              .removeClass(className.checked)
            ;
            if(!module.is.indeterminate() &&  module.is.unchecked() ) {
              module.debug('Input is already unchecked');
              return;
            }
            module.debug('Setting state to unchecked');
            $input
              .prop('indeterminate', false)
              .prop('checked', false)
            ;
            module.trigger.change();
          },
          indeterminate: function() {
            module.verbose('Setting class to indeterminate');
            $module
              .addClass(className.indeterminate)
            ;
            if( module.is.indeterminate() ) {
              module.debug('Input is already indeterminate, skipping input property change');
              return;
            }
            module.debug('Setting state to indeterminate');
            $input
              .prop('indeterminate', true)
            ;
            module.trigger.change();
          },
          determinate: function() {
            module.verbose('Removing indeterminate class');
            $module
              .removeClass(className.indeterminate)
            ;
            if( module.is.determinate() ) {
              module.debug('Input is already determinate, skipping input property change');
              return;
            }
            module.debug('Setting state to determinate');
            $input
              .prop('indeterminate', false)
            ;
          },
          disabled: function() {
            module.verbose('Setting class to disabled');
            $module
              .addClass(className.disabled)
            ;
            if( module.is.disabled() ) {
              module.debug('Input is already disabled, skipping input property change');
              return;
            }
            module.debug('Setting state to disabled');
            $input
              .prop('disabled', 'disabled')
            ;
            module.trigger.change();
          },
          enabled: function() {
            module.verbose('Removing disabled class');
            $module.removeClass(className.disabled);
            if( module.is.enabled() ) {
              module.debug('Input is already enabled, skipping input property change');
              return;
            }
            module.debug('Setting state to enabled');
            $input
              .prop('disabled', false)
            ;
            module.trigger.change();
          },
          tabbable: function() {
            module.verbose('Adding tabindex to checkbox');
            if( $input.attr('tabindex') === undefined) {
              $input.attr('tabindex', 0);
            }
          }
        },

        remove: {
          initialLoad: function() {
            initialLoad = false;
          }
        },

        trigger: {
          change: function() {
            var
              events       = document.createEvent('HTMLEvents'),
              inputElement = $input[0]
            ;
            if(inputElement) {
              module.verbose('Triggering native change event');
              events.initEvent('change', true, false);
              inputElement.dispatchEvent(events);
            }
          }
        },


        create: {
          label: function() {
            if($input.prevAll(selector.label).length > 0) {
              $input.prev(selector.label).detach().insertAfter($input);
              module.debug('Moving existing label', $label);
            }
            else if( !module.has.label() ) {
              $label = $('<label>').insertAfter($input);
              module.debug('Creating label', $label);
            }
          }
        },

        has: {
          label: function() {
            return ($label.length > 0);
          }
        },

        bind: {
          events: function() {
            module.verbose('Attaching checkbox events');
            $module
              .on('click'   + eventNamespace, module.event.click)
              .on('keydown' + eventNamespace, selector.input, module.event.keydown)
              .on('keyup'   + eventNamespace, selector.input, module.event.keyup)
            ;
          }
        },

        unbind: {
          events: function() {
            module.debug('Removing events');
            $module
              .off(eventNamespace)
            ;
          }
        },

        uncheckOthers: function() {
          var
            $radios = module.get.otherRadios()
          ;
          module.debug('Unchecking other radios', $radios);
          $radios.removeClass(className.checked);
        },

        toggle: function() {
          if( !module.can.change() ) {
            if(!module.is.radio()) {
              module.debug('Checkbox is read-only or disabled, ignoring toggle');
            }
            return;
          }
          if( module.is.indeterminate() || module.is.unchecked() ) {
            module.debug('Currently unchecked');
            module.check();
          }
          else if( module.is.checked() && module.can.uncheck() ) {
            module.debug('Currently checked');
            module.uncheck();
          }
        },
        setting: function(name, value) {
          module.debug('Changing setting', name, value);
          if( $.isPlainObject(name) ) {
            $.extend(true, settings, name);
          }
          else if(value !== undefined) {
            if($.isPlainObject(settings[name])) {
              $.extend(true, settings[name], value);
            }
            else {
              settings[name] = value;
            }
          }
          else {
            return settings[name];
          }
        },
        internal: function(name, value) {
          if( $.isPlainObject(name) ) {
            $.extend(true, module, name);
          }
          else if(value !== undefined) {
            module[name] = value;
          }
          else {
            return module[name];
          }
        },
        debug: function() {
          if(!settings.silent && settings.debug) {
            if(settings.performance) {
              module.performance.log(arguments);
            }
            else {
              module.debug = Function.prototype.bind.call(console.info, console, settings.name + ':');
              module.debug.apply(console, arguments);
            }
          }
        },
        verbose: function() {
          if(!settings.silent && settings.verbose && settings.debug) {
            if(settings.performance) {
              module.performance.log(arguments);
            }
            else {
              module.verbose = Function.prototype.bind.call(console.info, console, settings.name + ':');
              module.verbose.apply(console, arguments);
            }
          }
        },
        error: function() {
          if(!settings.silent) {
            module.error = Function.prototype.bind.call(console.error, console, settings.name + ':');
            module.error.apply(console, arguments);
          }
        },
        performance: {
          log: function(message) {
            var
              currentTime,
              executionTime,
              previousTime
            ;
            if(settings.performance) {
              currentTime   = new Date().getTime();
              previousTime  = time || currentTime;
              executionTime = currentTime - previousTime;
              time          = currentTime;
              performance.push({
                'Name'           : message[0],
                'Arguments'      : [].slice.call(message, 1) || '',
                'Element'        : element,
                'Execution Time' : executionTime
              });
            }
            clearTimeout(module.performance.timer);
            module.performance.timer = setTimeout(module.performance.display, 500);
          },
          display: function() {
            var
              title = settings.name + ':',
              totalTime = 0
            ;
            time = false;
            clearTimeout(module.performance.timer);
            $.each(performance, function(index, data) {
              totalTime += data['Execution Time'];
            });
            title += ' ' + totalTime + 'ms';
            if(moduleSelector) {
              title += ' \'' + moduleSelector + '\'';
            }
            if( (console.group !== undefined || console.table !== undefined) && performance.length > 0) {
              console.groupCollapsed(title);
              if(console.table) {
                console.table(performance);
              }
              else {
                $.each(performance, function(index, data) {
                  console.log(data['Name'] + ': ' + data['Execution Time']+'ms');
                });
              }
              console.groupEnd();
            }
            performance = [];
          }
        },
        invoke: function(query, passedArguments, context) {
          var
            object = instance,
            maxDepth,
            found,
            response
          ;
          passedArguments = passedArguments || queryArguments;
          context         = element         || context;
          if(typeof query == 'string' && object !== undefined) {
            query    = query.split(/[\. ]/);
            maxDepth = query.length - 1;
            $.each(query, function(depth, value) {
              var camelCaseValue = (depth != maxDepth)
                ? value + query[depth + 1].charAt(0).toUpperCase() + query[depth + 1].slice(1)
                : query
              ;
              if( $.isPlainObject( object[camelCaseValue] ) && (depth != maxDepth) ) {
                object = object[camelCaseValue];
              }
              else if( object[camelCaseValue] !== undefined ) {
                found = object[camelCaseValue];
                return false;
              }
              else if( $.isPlainObject( object[value] ) && (depth != maxDepth) ) {
                object = object[value];
              }
              else if( object[value] !== undefined ) {
                found = object[value];
                return false;
              }
              else {
                module.error(error.method, query);
                return false;
              }
            });
          }
          if ( $.isFunction( found ) ) {
            response = found.apply(context, passedArguments);
          }
          else if(found !== undefined) {
            response = found;
          }
          if($.isArray(returnedValue)) {
            returnedValue.push(response);
          }
          else if(returnedValue !== undefined) {
            returnedValue = [returnedValue, response];
          }
          else if(response !== undefined) {
            returnedValue = response;
          }
          return found;
        }
      };

      if(methodInvoked) {
        if(instance === undefined) {
          module.initialize();
        }
        module.invoke(query);
      }
      else {
        if(instance !== undefined) {
          instance.invoke('destroy');
        }
        module.initialize();
      }
    })
  ;

  return (returnedValue !== undefined)
    ? returnedValue
    : this
  ;
};

$.fn.checkbox.settings = {

  name                : 'Checkbox',
  namespace           : 'checkbox',

  silent              : false,
  debug               : false,
  verbose             : true,
  performance         : true,

  // delegated event context
  uncheckable         : 'auto',
  fireOnInit          : false,

  onChange            : function(){},

  beforeChecked       : function(){},
  beforeUnchecked     : function(){},
  beforeDeterminate   : function(){},
  beforeIndeterminate : function(){},

  onChecked           : function(){},
  onUnchecked         : function(){},

  onDeterminate       : function() {},
  onIndeterminate     : function() {},

  onEnable            : function(){},
  onDisable           : function(){},

  // preserve misspelled callbacks (will be removed in 3.0)
  onEnabled           : function(){},
  onDisabled          : function(){},

  className       : {
    checked       : 'checked',
    indeterminate : 'indeterminate',
    disabled      : 'disabled',
    hidden        : 'hidden',
    radio         : 'radio',
    readOnly      : 'read-only'
  },

  error     : {
    method       : 'The method you called is not defined'
  },

  selector : {
    checkbox : '.ui.checkbox',
    label    : 'label, .box',
    input    : 'input[type="checkbox"], input[type="radio"]',
    link     : 'a[href]'
  }

};

})( jQuery, window, document );

/*!
 * # Semantic UI 2.4.2 - Form Validation
 * http://github.com/semantic-org/semantic-ui/
 *
 *
 * Released under the MIT license
 * http://opensource.org/licenses/MIT
 *
 */

;(function ($, window, document, undefined) {

'use strict';

window = (typeof window != 'undefined' && window.Math == Math)
  ? window
  : (typeof self != 'undefined' && self.Math == Math)
    ? self
    : Function('return this')()
;

$.fn.form = function(parameters) {
  var
    $allModules      = $(this),
    moduleSelector   = $allModules.selector || '',

    time             = new Date().getTime(),
    performance      = [],

    query            = arguments[0],
    legacyParameters = arguments[1],
    methodInvoked    = (typeof query == 'string'),
    queryArguments   = [].slice.call(arguments, 1),
    returnedValue
  ;
  $allModules
    .each(function() {
      var
        $module     = $(this),
        element     = this,

        formErrors  = [],
        keyHeldDown = false,

        // set at run-time
        $field,
        $group,
        $message,
        $prompt,
        $submit,
        $clear,
        $reset,

        settings,
        validation,

        metadata,
        selector,
        className,
        regExp,
        error,

        namespace,
        moduleNamespace,
        eventNamespace,

        instance,
        module
      ;

      module      = {

        initialize: function() {

          // settings grabbed at run time
          module.get.settings();
          if(methodInvoked) {
            if(instance === undefined) {
              module.instantiate();
            }
            module.invoke(query);
          }
          else {
            if(instance !== undefined) {
              instance.invoke('destroy');
            }
            module.verbose('Initializing form validation', $module, settings);
            module.bindEvents();
            module.set.defaults();
            module.instantiate();
          }
        },

        instantiate: function() {
          module.verbose('Storing instance of module', module);
          instance = module;
          $module
            .data(moduleNamespace, module)
          ;
        },

        destroy: function() {
          module.verbose('Destroying previous module', instance);
          module.removeEvents();
          $module
            .removeData(moduleNamespace)
          ;
        },

        refresh: function() {
          module.verbose('Refreshing selector cache');
          $field      = $module.find(selector.field);
          $group      = $module.find(selector.group);
          $message    = $module.find(selector.message);
          $prompt     = $module.find(selector.prompt);

          $submit     = $module.find(selector.submit);
          $clear      = $module.find(selector.clear);
          $reset      = $module.find(selector.reset);
        },

        submit: function() {
          module.verbose('Submitting form', $module);
          $module
            .submit()
          ;
        },

        attachEvents: function(selector, action) {
          action = action || 'submit';
          $(selector)
            .on('click' + eventNamespace, function(event) {
              module[action]();
              event.preventDefault();
            })
          ;
        },

        bindEvents: function() {
          module.verbose('Attaching form events');
          $module
            .on('submit' + eventNamespace, module.validate.form)
            .on('blur'   + eventNamespace, selector.field, module.event.field.blur)
            .on('click'  + eventNamespace, selector.submit, module.submit)
            .on('click'  + eventNamespace, selector.reset, module.reset)
            .on('click'  + eventNamespace, selector.clear, module.clear)
          ;
          if(settings.keyboardShortcuts) {
            $module
              .on('keydown' + eventNamespace, selector.field, module.event.field.keydown)
            ;
          }
          $field
            .each(function() {
              var
                $input     = $(this),
                type       = $input.prop('type'),
                inputEvent = module.get.changeEvent(type, $input)
              ;
              $(this)
                .on(inputEvent + eventNamespace, module.event.field.change)
              ;
            })
          ;
        },

        clear: function() {
          $field
            .each(function () {
              var
                $field       = $(this),
                $element     = $field.parent(),
                $fieldGroup  = $field.closest($group),
                $prompt      = $fieldGroup.find(selector.prompt),
                defaultValue = $field.data(metadata.defaultValue) || '',
                isCheckbox   = $element.is(selector.uiCheckbox),
                isDropdown   = $element.is(selector.uiDropdown),
                isErrored    = $fieldGroup.hasClass(className.error)
              ;
              if(isErrored) {
                module.verbose('Resetting error on field', $fieldGroup);
                $fieldGroup.removeClass(className.error);
                $prompt.remove();
              }
              if(isDropdown) {
                module.verbose('Resetting dropdown value', $element, defaultValue);
                $element.dropdown('clear');
              }
              else if(isCheckbox) {
                $field.prop('checked', false);
              }
              else {
                module.verbose('Resetting field value', $field, defaultValue);
                $field.val('');
              }
            })
          ;
        },

        reset: function() {
          $field
            .each(function () {
              var
                $field       = $(this),
                $element     = $field.parent(),
                $fieldGroup  = $field.closest($group),
                $prompt      = $fieldGroup.find(selector.prompt),
                defaultValue = $field.data(metadata.defaultValue),
                isCheckbox   = $element.is(selector.uiCheckbox),
                isDropdown   = $element.is(selector.uiDropdown),
                isErrored    = $fieldGroup.hasClass(className.error)
              ;
              if(defaultValue === undefined) {
                return;
              }
              if(isErrored) {
                module.verbose('Resetting error on field', $fieldGroup);
                $fieldGroup.removeClass(className.error);
                $prompt.remove();
              }
              if(isDropdown) {
                module.verbose('Resetting dropdown value', $element, defaultValue);
                $element.dropdown('restore defaults');
              }
              else if(isCheckbox) {
                module.verbose('Resetting checkbox value', $element, defaultValue);
                $field.prop('checked', defaultValue);
              }
              else {
                module.verbose('Resetting field value', $field, defaultValue);
                $field.val(defaultValue);
              }
            })
          ;
        },

        determine: {
          isValid: function() {
            var
              allValid = true
            ;
            $.each(validation, function(fieldName, field) {
              if( !( module.validate.field(field, fieldName, true) ) ) {
                allValid = false;
              }
            });
            return allValid;
          }
        },

        is: {
          bracketedRule: function(rule) {
            return (rule.type && rule.type.match(settings.regExp.bracket));
          },
          shorthandFields: function(fields) {
            var
              fieldKeys = Object.keys(fields),
              firstRule = fields[fieldKeys[0]]
            ;
            return module.is.shorthandRules(firstRule);
          },
          // duck type rule test
          shorthandRules: function(rules) {
            return (typeof rules == 'string' || $.isArray(rules));
          },
          empty: function($field) {
            if(!$field || $field.length === 0) {
              return true;
            }
            else if($field.is('input[type="checkbox"]')) {
              return !$field.is(':checked');
            }
            else {
              return module.is.blank($field);
            }
          },
          blank: function($field) {
            return $.trim($field.val()) === '';
          },
          valid: function(field) {
            var
              allValid = true
            ;
            if(field) {
              module.verbose('Checking if field is valid', field);
              return module.validate.field(validation[field], field, false);
            }
            else {
              module.verbose('Checking if form is valid');
              $.each(validation, function(fieldName, field) {
                if( !module.is.valid(fieldName) ) {
                  allValid = false;
                }
              });
              return allValid;
            }
          }
        },

        removeEvents: function() {
          $module
            .off(eventNamespace)
          ;
          $field
            .off(eventNamespace)
          ;
          $submit
            .off(eventNamespace)
          ;
          $field
            .off(eventNamespace)
          ;
        },

        event: {
          field: {
            keydown: function(event) {
              var
                $field       = $(this),
                key          = event.which,
                isInput      = $field.is(selector.input),
                isCheckbox   = $field.is(selector.checkbox),
                isInDropdown = ($field.closest(selector.uiDropdown).length > 0),
                keyCode      = {
                  enter  : 13,
                  escape : 27
                }
              ;
              if( key == keyCode.escape) {
                module.verbose('Escape key pressed blurring field');
                $field
                  .blur()
                ;
              }
              if(!event.ctrlKey && key == keyCode.enter && isInput && !isInDropdown && !isCheckbox) {
                if(!keyHeldDown) {
                  $field
                    .one('keyup' + eventNamespace, module.event.field.keyup)
                  ;
                  module.submit();
                  module.debug('Enter pressed on input submitting form');
                }
                keyHeldDown = true;
              }
            },
            keyup: function() {
              keyHeldDown = false;
            },
            blur: function(event) {
              var
                $field          = $(this),
                $fieldGroup     = $field.closest($group),
                validationRules = module.get.validation($field)
              ;
              if( $fieldGroup.hasClass(className.error) ) {
                module.debug('Revalidating field', $field, validationRules);
                if(validationRules) {
                  module.validate.field( validationRules );
                }
              }
              else if(settings.on == 'blur') {
                if(validationRules) {
                  module.validate.field( validationRules );
                }
              }
            },
            change: function(event) {
              var
                $field      = $(this),
                $fieldGroup = $field.closest($group),
                validationRules = module.get.validation($field)
              ;
              if(validationRules && (settings.on == 'change' || ( $fieldGroup.hasClass(className.error) && settings.revalidate) )) {
                clearTimeout(module.timer);
                module.timer = setTimeout(function() {
                  module.debug('Revalidating field', $field,  module.get.validation($field));
                  module.validate.field( validationRules );
                }, settings.delay);
              }
            }
          }

        },

        get: {
          ancillaryValue: function(rule) {
            if(!rule.type || (!rule.value && !module.is.bracketedRule(rule))) {
              return false;
            }
            return (rule.value !== undefined)
              ? rule.value
              : rule.type.match(settings.regExp.bracket)[1] + ''
            ;
          },
          ruleName: function(rule) {
            if( module.is.bracketedRule(rule) ) {
              return rule.type.replace(rule.type.match(settings.regExp.bracket)[0], '');
            }
            return rule.type;
          },
          changeEvent: function(type, $input) {
            if(type == 'checkbox' || type == 'radio' || type == 'hidden' || $input.is('select')) {
              return 'change';
            }
            else {
              return module.get.inputEvent();
            }
          },
          inputEvent: function() {
            return (document.createElement('input').oninput !== undefined)
              ? 'input'
              : (document.createElement('input').onpropertychange !== undefined)
                ? 'propertychange'
                : 'keyup'
            ;
          },
          fieldsFromShorthand: function(fields) {
            var
              fullFields = {}
            ;
            $.each(fields, function(name, rules) {
              if(typeof rules == 'string') {
                rules = [rules];
              }
              fullFields[name] = {
                rules: []
              };
              $.each(rules, function(index, rule) {
                fullFields[name].rules.push({ type: rule });
              });
            });
            return fullFields;
          },
          prompt: function(rule, field) {
            var
              ruleName      = module.get.ruleName(rule),
              ancillary     = module.get.ancillaryValue(rule),
              $field        = module.get.field(field.identifier),
              value         = $field.val(),
              prompt        = $.isFunction(rule.prompt)
                ? rule.prompt(value)
                : rule.prompt || settings.prompt[ruleName] || settings.text.unspecifiedRule,
              requiresValue = (prompt.search('{value}') !== -1),
              requiresName  = (prompt.search('{name}') !== -1),
              $label,
              name
            ;
            if(requiresValue) {
              prompt = prompt.replace('{value}', $field.val());
            }
            if(requiresName) {
              $label = $field.closest(selector.group).find('label').eq(0);
              name = ($label.length == 1)
                ? $label.text()
                : $field.prop('placeholder') || settings.text.unspecifiedField
              ;
              prompt = prompt.replace('{name}', name);
            }
            prompt = prompt.replace('{identifier}', field.identifier);
            prompt = prompt.replace('{ruleValue}', ancillary);
            if(!rule.prompt) {
              module.verbose('Using default validation prompt for type', prompt, ruleName);
            }
            return prompt;
          },
          settings: function() {
            if($.isPlainObject(parameters)) {
              var
                keys     = Object.keys(parameters),
                isLegacySettings = (keys.length > 0)
                  ? (parameters[keys[0]].identifier !== undefined && parameters[keys[0]].rules !== undefined)
                  : false,
                ruleKeys
              ;
              if(isLegacySettings) {
                // 1.x (ducktyped)
                settings   = $.extend(true, {}, $.fn.form.settings, legacyParameters);
                validation = $.extend({}, $.fn.form.settings.defaults, parameters);
                module.error(settings.error.oldSyntax, element);
                module.verbose('Extending settings from legacy parameters', validation, settings);
              }
              else {
                // 2.x
                if(parameters.fields && module.is.shorthandFields(parameters.fields)) {
                  parameters.fields = module.get.fieldsFromShorthand(parameters.fields);
                }
                settings   = $.extend(true, {}, $.fn.form.settings, parameters);
                validation = $.extend({}, $.fn.form.settings.defaults, settings.fields);
                module.verbose('Extending settings', validation, settings);
              }
            }
            else {
              settings   = $.fn.form.settings;
              validation = $.fn.form.settings.defaults;
              module.verbose('Using default form validation', validation, settings);
            }

            // shorthand
            namespace       = settings.namespace;
            metadata        = settings.metadata;
            selector        = settings.selector;
            className       = settings.className;
            regExp          = settings.regExp;
            error           = settings.error;
            moduleNamespace = 'module-' + namespace;
            eventNamespace  = '.' + namespace;

            // grab instance
            instance = $module.data(moduleNamespace);

            // refresh selector cache
            module.refresh();
          },
          field: function(identifier) {
            module.verbose('Finding field with identifier', identifier);
            identifier = module.escape.string(identifier);
            if($field.filter('#' + identifier).length > 0 ) {
              return $field.filter('#' + identifier);
            }
            else if( $field.filter('[name="' + identifier +'"]').length > 0 ) {
              return $field.filter('[name="' + identifier +'"]');
            }
            else if( $field.filter('[name="' + identifier +'[]"]').length > 0 ) {
              return $field.filter('[name="' + identifier +'[]"]');
            }
            else if( $field.filter('[data-' + metadata.validate + '="'+ identifier +'"]').length > 0 ) {
              return $field.filter('[data-' + metadata.validate + '="'+ identifier +'"]');
            }
            return $('<input/>');
          },
          fields: function(fields) {
            var
              $fields = $()
            ;
            $.each(fields, function(index, name) {
              $fields = $fields.add( module.get.field(name) );
            });
            return $fields;
          },
          validation: function($field) {
            var
              fieldValidation,
              identifier
            ;
            if(!validation) {
              return false;
            }
            $.each(validation, function(fieldName, field) {
              identifier = field.identifier || fieldName;
              if( module.get.field(identifier)[0] == $field[0] ) {
                field.identifier = identifier;
                fieldValidation = field;
              }
            });
            return fieldValidation || false;
          },
          value: function (field) {
            var
              fields = [],
              results
            ;
            fields.push(field);
            results = module.get.values.call(element, fields);
            return results[field];
          },
          values: function (fields) {
            var
              $fields = $.isArray(fields)
                ? module.get.fields(fields)
                : $field,
              values = {}
            ;
            $fields.each(function(index, field) {
              var
                $field     = $(field),
                type       = $field.prop('type'),
                name       = $field.prop('name'),
                value      = $field.val(),
                isCheckbox = $field.is(selector.checkbox),
                isRadio    = $field.is(selector.radio),
                isMultiple = (name.indexOf('[]') !== -1),
                isChecked  = (isCheckbox)
                  ? $field.is(':checked')
                  : false
              ;
              if(name) {
                if(isMultiple) {
                  name = name.replace('[]', '');
                  if(!values[name]) {
                    values[name] = [];
                  }
                  if(isCheckbox) {
                    if(isChecked) {
                      values[name].push(value || true);
                    }
                    else {
                      values[name].push(false);
                    }
                  }
                  else {
                    values[name].push(value);
                  }
                }
                else {
                  if(isRadio) {
                    if(values[name] === undefined || values[name] == false) {
                      values[name] = (isChecked)
                        ? value || true
                        : false
                      ;
                    }
                  }
                  else if(isCheckbox) {
                    if(isChecked) {
                      values[name] = value || true;
                    }
                    else {
                      values[name] = false;
                    }
                  }
                  else {
                    values[name] = value;
                  }
                }
              }
            });
            return values;
          }
        },

        has: {

          field: function(identifier) {
            module.verbose('Checking for existence of a field with identifier', identifier);
            identifier = module.escape.string(identifier);
            if(typeof identifier !== 'string') {
              module.error(error.identifier, identifier);
            }
            if($field.filter('#' + identifier).length > 0 ) {
              return true;
            }
            else if( $field.filter('[name="' + identifier +'"]').length > 0 ) {
              return true;
            }
            else if( $field.filter('[data-' + metadata.validate + '="'+ identifier +'"]').length > 0 ) {
              return true;
            }
            return false;
          }

        },

        escape: {
          string: function(text) {
            text =  String(text);
            return text.replace(regExp.escape, '\\$&');
          }
        },

        add: {
          // alias
          rule: function(name, rules) {
            module.add.field(name, rules);
          },
          field: function(name, rules) {
            var
              newValidation = {}
            ;
            if(module.is.shorthandRules(rules)) {
              rules = $.isArray(rules)
                ? rules
                : [rules]
              ;
              newValidation[name] = {
                rules: []
              };
              $.each(rules, function(index, rule) {
                newValidation[name].rules.push({ type: rule });
              });
            }
            else {
              newValidation[name] = rules;
            }
            validation = $.extend({}, validation, newValidation);
            module.debug('Adding rules', newValidation, validation);
          },
          fields: function(fields) {
            var
              newValidation
            ;
            if(fields && module.is.shorthandFields(fields)) {
              newValidation = module.get.fieldsFromShorthand(fields);
            }
            else {
              newValidation = fields;
            }
            validation = $.extend({}, validation, newValidation);
          },
          prompt: function(identifier, errors) {
            var
              $field       = module.get.field(identifier),
              $fieldGroup  = $field.closest($group),
              $prompt      = $fieldGroup.children(selector.prompt),
              promptExists = ($prompt.length !== 0)
            ;
            errors = (typeof errors == 'string')
              ? [errors]
              : errors
            ;
            module.verbose('Adding field error state', identifier);
            $fieldGroup
              .addClass(className.error)
            ;
            if(settings.inline) {
              if(!promptExists) {
                $prompt = settings.templates.prompt(errors);
                $prompt
                  .appendTo($fieldGroup)
                ;
              }
              $prompt
                .html(errors[0])
              ;
              if(!promptExists) {
                if(settings.transition && $.fn.transition !== undefined && $module.transition('is supported')) {
                  module.verbose('Displaying error with css transition', settings.transition);
                  $prompt.transition(settings.transition + ' in', settings.duration);
                }
                else {
                  module.verbose('Displaying error with fallback javascript animation');
                  $prompt
                    .fadeIn(settings.duration)
                  ;
                }
              }
              else {
                module.verbose('Inline errors are disabled, no inline error added', identifier);
              }
            }
          },
          errors: function(errors) {
            module.debug('Adding form error messages', errors);
            module.set.error();
            $message
              .html( settings.templates.error(errors) )
            ;
          }
        },

        remove: {
          rule: function(field, rule) {
            var
              rules = $.isArray(rule)
                ? rule
                : [rule]
            ;
            if(rule == undefined) {
              module.debug('Removed all rules');
              validation[field].rules = [];
              return;
            }
            if(validation[field] == undefined || !$.isArray(validation[field].rules)) {
              return;
            }
            $.each(validation[field].rules, function(index, rule) {
              if(rules.indexOf(rule.type) !== -1) {
                module.debug('Removed rule', rule.type);
                validation[field].rules.splice(index, 1);
              }
            });
          },
          field: function(field) {
            var
              fields = $.isArray(field)
                ? field
                : [field]
            ;
            $.each(fields, function(index, field) {
              module.remove.rule(field);
            });
          },
          // alias
          rules: function(field, rules) {
            if($.isArray(field)) {
              $.each(fields, function(index, field) {
                module.remove.rule(field, rules);
              });
            }
            else {
              module.remove.rule(field, rules);
            }
          },
          fields: function(fields) {
            module.remove.field(fields);
          },
          prompt: function(identifier) {
            var
              $field      = module.get.field(identifier),
              $fieldGroup = $field.closest($group),
              $prompt     = $fieldGroup.children(selector.prompt)
            ;
            $fieldGroup
              .removeClass(className.error)
            ;
            if(settings.inline && $prompt.is(':visible')) {
              module.verbose('Removing prompt for field', identifier);
              if(settings.transition && $.fn.transition !== undefined && $module.transition('is supported')) {
                $prompt.transition(settings.transition + ' out', settings.duration, function() {
                  $prompt.remove();
                });
              }
              else {
                $prompt
                  .fadeOut(settings.duration, function(){
                    $prompt.remove();
                  })
                ;
              }
            }
          }
        },

        set: {
          success: function() {
            $module
              .removeClass(className.error)
              .addClass(className.success)
            ;
          },
          defaults: function () {
            $field
              .each(function () {
                var
                  $field     = $(this),
                  isCheckbox = ($field.filter(selector.checkbox).length > 0),
                  value      = (isCheckbox)
                    ? $field.is(':checked')
                    : $field.val()
                ;
                $field.data(metadata.defaultValue, value);
              })
            ;
          },
          error: function() {
            $module
              .removeClass(className.success)
              .addClass(className.error)
            ;
          },
          value: function (field, value) {
            var
              fields = {}
            ;
            fields[field] = value;
            return module.set.values.call(element, fields);
          },
          values: function (fields) {
            if($.isEmptyObject(fields)) {
              return;
            }
            $.each(fields, function(key, value) {
              var
                $field      = module.get.field(key),
                $element    = $field.parent(),
                isMultiple  = $.isArray(value),
                isCheckbox  = $element.is(selector.uiCheckbox),
                isDropdown  = $element.is(selector.uiDropdown),
                isRadio     = ($field.is(selector.radio) && isCheckbox),
                fieldExists = ($field.length > 0),
                $multipleField
              ;
              if(fieldExists) {
                if(isMultiple && isCheckbox) {
                  module.verbose('Selecting multiple', value, $field);
                  $element.checkbox('uncheck');
                  $.each(value, function(index, value) {
                    $multipleField = $field.filter('[value="' + value + '"]');
                    $element       = $multipleField.parent();
                    if($multipleField.length > 0) {
                      $element.checkbox('check');
                    }
                  });
                }
                else if(isRadio) {
                  module.verbose('Selecting radio value', value, $field);
                  $field.filter('[value="' + value + '"]')
                    .parent(selector.uiCheckbox)
                      .checkbox('check')
                  ;
                }
                else if(isCheckbox) {
                  module.verbose('Setting checkbox value', value, $element);
                  if(value === true) {
                    $element.checkbox('check');
                  }
                  else {
                    $element.checkbox('uncheck');
                  }
                }
                else if(isDropdown) {
                  module.verbose('Setting dropdown value', value, $element);
                  $element.dropdown('set selected', value);
                }
                else {
                  module.verbose('Setting field value', value, $field);
                  $field.val(value);
                }
              }
            });
          }
        },

        validate: {

          form: function(event, ignoreCallbacks) {
            var
              values = module.get.values(),
              apiRequest
            ;

            // input keydown event will fire submit repeatedly by browser default
            if(keyHeldDown) {
              return false;
            }

            // reset errors
            formErrors = [];
            if( module.determine.isValid() ) {
              module.debug('Form has no validation errors, submitting');
              module.set.success();
              if(ignoreCallbacks !== true) {
                return settings.onSuccess.call(element, event, values);
              }
            }
            else {
              module.debug('Form has errors');
              module.set.error();
              if(!settings.inline) {
                module.add.errors(formErrors);
              }
              // prevent ajax submit
              if($module.data('moduleApi') !== undefined) {
                event.stopImmediatePropagation();
              }
              if(ignoreCallbacks !== true) {
                return settings.onFailure.call(element, formErrors, values);
              }
            }
          },

          // takes a validation object and returns whether field passes validation
          field: function(field, fieldName, showErrors) {
            showErrors = (showErrors !== undefined)
              ? showErrors
              : true
            ;
            if(typeof field == 'string') {
              module.verbose('Validating field', field);
              fieldName = field;
              field     = validation[field];
            }
            var
              identifier    = field.identifier || fieldName,
              $field        = module.get.field(identifier),
              $dependsField = (field.depends)
                ? module.get.field(field.depends)
                : false,
              fieldValid  = true,
              fieldErrors = []
            ;
            if(!field.identifier) {
              module.debug('Using field name as identifier', identifier);
              field.identifier = identifier;
            }
            if($field.prop('disabled')) {
              module.debug('Field is disabled. Skipping', identifier);
              fieldValid = true;
            }
            else if(field.optional && module.is.blank($field)){
              module.debug('Field is optional and blank. Skipping', identifier);
              fieldValid = true;
            }
            else if(field.depends && module.is.empty($dependsField)) {
              module.debug('Field depends on another value that is not present or empty. Skipping', $dependsField);
              fieldValid = true;
            }
            else if(field.rules !== undefined) {
              $.each(field.rules, function(index, rule) {
                if( module.has.field(identifier) && !( module.validate.rule(field, rule) ) ) {
                  module.debug('Field is invalid', identifier, rule.type);
                  fieldErrors.push(module.get.prompt(rule, field));
                  fieldValid = false;
                }
              });
            }
            if(fieldValid) {
              if(showErrors) {
                module.remove.prompt(identifier, fieldErrors);
                settings.onValid.call($field);
              }
            }
            else {
              if(showErrors) {
                formErrors = formErrors.concat(fieldErrors);
                module.add.prompt(identifier, fieldErrors);
                settings.onInvalid.call($field, fieldErrors);
              }
              return false;
            }
            return true;
          },

          // takes validation rule and returns whether field passes rule
          rule: function(field, rule) {
            var
              $field       = module.get.field(field.identifier),
              type         = rule.type,
              value        = $field.val(),
              isValid      = true,
              ancillary    = module.get.ancillaryValue(rule),
              ruleName     = module.get.ruleName(rule),
              ruleFunction = settings.rules[ruleName]
            ;
            if( !$.isFunction(ruleFunction) ) {
              module.error(error.noRule, ruleName);
              return;
            }
            // cast to string avoiding encoding special values
            value = (value === undefined || value === '' || value === null)
              ? ''
              : $.trim(value + '')
            ;
            return ruleFunction.call($field, value, ancillary);
          }
        },

        setting: function(name, value) {
          if( $.isPlainObject(name) ) {
            $.extend(true, settings, name);
          }
          else if(value !== undefined) {
            settings[name] = value;
          }
          else {
            return settings[name];
          }
        },
        internal: function(name, value) {
          if( $.isPlainObject(name) ) {
            $.extend(true, module, name);
          }
          else if(value !== undefined) {
            module[name] = value;
          }
          else {
            return module[name];
          }
        },
        debug: function() {
          if(!settings.silent && settings.debug) {
            if(settings.performance) {
              module.performance.log(arguments);
            }
            else {
              module.debug = Function.prototype.bind.call(console.info, console, settings.name + ':');
              module.debug.apply(console, arguments);
            }
          }
        },
        verbose: function() {
          if(!settings.silent && settings.verbose && settings.debug) {
            if(settings.performance) {
              module.performance.log(arguments);
            }
            else {
              module.verbose = Function.prototype.bind.call(console.info, console, settings.name + ':');
              module.verbose.apply(console, arguments);
            }
          }
        },
        error: function() {
          if(!settings.silent) {
            module.error = Function.prototype.bind.call(console.error, console, settings.name + ':');
            module.error.apply(console, arguments);
          }
        },
        performance: {
          log: function(message) {
            var
              currentTime,
              executionTime,
              previousTime
            ;
            if(settings.performance) {
              currentTime   = new Date().getTime();
              previousTime  = time || currentTime;
              executionTime = currentTime - previousTime;
              time          = currentTime;
              performance.push({
                'Name'           : message[0],
                'Arguments'      : [].slice.call(message, 1) || '',
                'Element'        : element,
                'Execution Time' : executionTime
              });
            }
            clearTimeout(module.performance.timer);
            module.performance.timer = setTimeout(module.performance.display, 500);
          },
          display: function() {
            var
              title = settings.name + ':',
              totalTime = 0
            ;
            time = false;
            clearTimeout(module.performance.timer);
            $.each(performance, function(index, data) {
              totalTime += data['Execution Time'];
            });
            title += ' ' + totalTime + 'ms';
            if(moduleSelector) {
              title += ' \'' + moduleSelector + '\'';
            }
            if($allModules.length > 1) {
              title += ' ' + '(' + $allModules.length + ')';
            }
            if( (console.group !== undefined || console.table !== undefined) && performance.length > 0) {
              console.groupCollapsed(title);
              if(console.table) {
                console.table(performance);
              }
              else {
                $.each(performance, function(index, data) {
                  console.log(data['Name'] + ': ' + data['Execution Time']+'ms');
                });
              }
              console.groupEnd();
            }
            performance = [];
          }
        },
        invoke: function(query, passedArguments, context) {
          var
            object = instance,
            maxDepth,
            found,
            response
          ;
          passedArguments = passedArguments || queryArguments;
          context         = element         || context;
          if(typeof query == 'string' && object !== undefined) {
            query    = query.split(/[\. ]/);
            maxDepth = query.length - 1;
            $.each(query, function(depth, value) {
              var camelCaseValue = (depth != maxDepth)
                ? value + query[depth + 1].charAt(0).toUpperCase() + query[depth + 1].slice(1)
                : query
              ;
              if( $.isPlainObject( object[camelCaseValue] ) && (depth != maxDepth) ) {
                object = object[camelCaseValue];
              }
              else if( object[camelCaseValue] !== undefined ) {
                found = object[camelCaseValue];
                return false;
              }
              else if( $.isPlainObject( object[value] ) && (depth != maxDepth) ) {
                object = object[value];
              }
              else if( object[value] !== undefined ) {
                found = object[value];
                return false;
              }
              else {
                return false;
              }
            });
          }
          if( $.isFunction( found ) ) {
            response = found.apply(context, passedArguments);
          }
          else if(found !== undefined) {
            response = found;
          }
          if($.isArray(returnedValue)) {
            returnedValue.push(response);
          }
          else if(returnedValue !== undefined) {
            returnedValue = [returnedValue, response];
          }
          else if(response !== undefined) {
            returnedValue = response;
          }
          return found;
        }
      };
      module.initialize();
    })
  ;

  return (returnedValue !== undefined)
    ? returnedValue
    : this
  ;
};

$.fn.form.settings = {

  name              : 'Form',
  namespace         : 'form',

  debug             : false,
  verbose           : false,
  performance       : true,

  fields            : false,

  keyboardShortcuts : true,
  on                : 'submit',
  inline            : false,

  delay             : 200,
  revalidate        : true,

  transition        : 'scale',
  duration          : 200,

  onValid           : function() {},
  onInvalid         : function() {},
  onSuccess         : function() { return true; },
  onFailure         : function() { return false; },

  metadata : {
    defaultValue : 'default',
    validate     : 'validate'
  },

  regExp: {
    htmlID  : /^[a-zA-Z][\w:.-]*$/g,
    bracket : /\[(.*)\]/i,
    decimal : /^\d+\.?\d*$/,
    email   : /^[a-z0-9!#$%&'*+\/=?^_`{|}~.-]+@[a-z0-9]([a-z0-9-]*[a-z0-9])?(\.[a-z0-9]([a-z0-9-]*[a-z0-9])?)*$/i,
    escape  : /[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g,
    flags   : /^\/(.*)\/(.*)?/,
    integer : /^\-?\d+$/,
    number  : /^\-?\d*(\.\d+)?$/,
    url     : /(https?:\/\/(?:www\.|(?!www))[^\s\.]+\.[^\s]{2,}|www\.[^\s]+\.[^\s]{2,})/i
  },

  text: {
    unspecifiedRule  : 'Please enter a valid value',
    unspecifiedField : 'This field'
  },

  prompt: {
    empty                : '{name} must have a value',
    checked              : '{name} must be checked',
    email                : '{name} must be a valid e-mail',
    url                  : '{name} must be a valid url',
    regExp               : '{name} is not formatted correctly',
    integer              : '{name} must be an integer',
    decimal              : '{name} must be a decimal number',
    number               : '{name} must be set to a number',
    is                   : '{name} must be "{ruleValue}"',
    isExactly            : '{name} must be exactly "{ruleValue}"',
    not                  : '{name} cannot be set to "{ruleValue}"',
    notExactly           : '{name} cannot be set to exactly "{ruleValue}"',
    contain              : '{name} must contain "{ruleValue}"',
    containExactly       : '{name} must contain exactly "{ruleValue}"',
    doesntContain        : '{name} cannot contain  "{ruleValue}"',
    doesntContainExactly : '{name} cannot contain exactly "{ruleValue}"',
    minLength            : '{name} must be at least {ruleValue} characters',
    length               : '{name} must be at least {ruleValue} characters',
    exactLength          : '{name} must be exactly {ruleValue} characters',
    maxLength            : '{name} cannot be longer than {ruleValue} characters',
    match                : '{name} must match {ruleValue} field',
    different            : '{name} must have a different value than {ruleValue} field',
    creditCard           : '{name} must be a valid credit card number',
    minCount             : '{name} must have at least {ruleValue} choices',
    exactCount           : '{name} must have exactly {ruleValue} choices',
    maxCount             : '{name} must have {ruleValue} or less choices'
  },

  selector : {
    checkbox   : 'input[type="checkbox"], input[type="radio"]',
    clear      : '.clear',
    field      : 'input, textarea, select',
    group      : '.field',
    input      : 'input',
    message    : '.error.message',
    prompt     : '.prompt.label',
    radio      : 'input[type="radio"]',
    reset      : '.reset:not([type="reset"])',
    submit     : '.submit:not([type="submit"])',
    uiCheckbox : '.ui.checkbox',
    uiDropdown : '.ui.dropdown'
  },

  className : {
    error   : 'error',
    label   : 'ui prompt label',
    pressed : 'down',
    success : 'success'
  },

  error: {
    identifier : 'You must specify a string identifier for each field',
    method     : 'The method you called is not defined.',
    noRule     : 'There is no rule matching the one you specified',
    oldSyntax  : 'Starting in 2.0 forms now only take a single settings object. Validation settings converted to new syntax automatically.'
  },

  templates: {

    // template that produces error message
    error: function(errors) {
      var
        html = '<ul class="list">'
      ;
      $.each(errors, function(index, value) {
        html += '<li>' + value + '</li>';
      });
      html += '</ul>';
      return $(html);
    },

    // template that produces label
    prompt: function(errors) {
      return $('<div/>')
        .addClass('ui basic red pointing prompt label')
        .html(errors[0])
      ;
    }
  },

  rules: {

    // is not empty or blank string
    empty: function(value) {
      return !(value === undefined || '' === value || $.isArray(value) && value.length === 0);
    },

    // checkbox checked
    checked: function() {
      return ($(this).filter(':checked').length > 0);
    },

    // is most likely an email
    email: function(value){
      return $.fn.form.settings.regExp.email.test(value);
    },

    // value is most likely url
    url: function(value) {
      return $.fn.form.settings.regExp.url.test(value);
    },

    // matches specified regExp
    regExp: function(value, regExp) {
      if(regExp instanceof RegExp) {
        return value.match(regExp);
      }
      var
        regExpParts = regExp.match($.fn.form.settings.regExp.flags),
        flags
      ;
      // regular expression specified as /baz/gi (flags)
      if(regExpParts) {
        regExp = (regExpParts.length >= 2)
          ? regExpParts[1]
          : regExp
        ;
        flags = (regExpParts.length >= 3)
          ? regExpParts[2]
          : ''
        ;
      }
      return value.match( new RegExp(regExp, flags) );
    },

    // is valid integer or matches range
    integer: function(value, range) {
      var
        intRegExp = $.fn.form.settings.regExp.integer,
        min,
        max,
        parts
      ;
      if( !range || ['', '..'].indexOf(range) !== -1) {
        // do nothing
      }
      else if(range.indexOf('..') == -1) {
        if(intRegExp.test(range)) {
          min = max = range - 0;
        }
      }
      else {
        parts = range.split('..', 2);
        if(intRegExp.test(parts[0])) {
          min = parts[0] - 0;
        }
        if(intRegExp.test(parts[1])) {
          max = parts[1] - 0;
        }
      }
      return (
        intRegExp.test(value) &&
        (min === undefined || value >= min) &&
        (max === undefined || value <= max)
      );
    },

    // is valid number (with decimal)
    decimal: function(value) {
      return $.fn.form.settings.regExp.decimal.test(value);
    },

    // is valid number
    number: function(value) {
      return $.fn.form.settings.regExp.number.test(value);
    },

    // is value (case insensitive)
    is: function(value, text) {
      text = (typeof text == 'string')
        ? text.toLowerCase()
        : text
      ;
      value = (typeof value == 'string')
        ? value.toLowerCase()
        : value
      ;
      return (value == text);
    },

    // is value
    isExactly: function(value, text) {
      return (value == text);
    },

    // value is not another value (case insensitive)
    not: function(value, notValue) {
      value = (typeof value == 'string')
        ? value.toLowerCase()
        : value
      ;
      notValue = (typeof notValue == 'string')
        ? notValue.toLowerCase()
        : notValue
      ;
      return (value != notValue);
    },

    // value is not another value (case sensitive)
    notExactly: function(value, notValue) {
      return (value != notValue);
    },

    // value contains text (insensitive)
    contains: function(value, text) {
      // escape regex characters
      text = text.replace($.fn.form.settings.regExp.escape, "\\$&");
      return (value.search( new RegExp(text, 'i') ) !== -1);
    },

    // value contains text (case sensitive)
    containsExactly: function(value, text) {
      // escape regex characters
      text = text.replace($.fn.form.settings.regExp.escape, "\\$&");
      return (value.search( new RegExp(text) ) !== -1);
    },

    // value contains text (insensitive)
    doesntContain: function(value, text) {
      // escape regex characters
      text = text.replace($.fn.form.settings.regExp.escape, "\\$&");
      return (value.search( new RegExp(text, 'i') ) === -1);
    },

    // value contains text (case sensitive)
    doesntContainExactly: function(value, text) {
      // escape regex characters
      text = text.replace($.fn.form.settings.regExp.escape, "\\$&");
      return (value.search( new RegExp(text) ) === -1);
    },

    // is at least string length
    minLength: function(value, requiredLength) {
      return (value !== undefined)
        ? (value.length >= requiredLength)
        : false
      ;
    },

    // see rls notes for 2.0.6 (this is a duplicate of minLength)
    length: function(value, requiredLength) {
      return (value !== undefined)
        ? (value.length >= requiredLength)
        : false
      ;
    },

    // is exactly length
    exactLength: function(value, requiredLength) {
      return (value !== undefined)
        ? (value.length == requiredLength)
        : false
      ;
    },

    // is less than length
    maxLength: function(value, maxLength) {
      return (value !== undefined)
        ? (value.length <= maxLength)
        : false
      ;
    },

    // matches another field
    match: function(value, identifier) {
      var
        $form = $(this),
        matchingValue
      ;
      if( $('[data-validate="'+ identifier +'"]').length > 0 ) {
        matchingValue = $('[data-validate="'+ identifier +'"]').val();
      }
      else if($('#' + identifier).length > 0) {
        matchingValue = $('#' + identifier).val();
      }
      else if($('[name="' + identifier +'"]').length > 0) {
        matchingValue = $('[name="' + identifier + '"]').val();
      }
      else if( $('[name="' + identifier +'[]"]').length > 0 ) {
        matchingValue = $('[name="' + identifier +'[]"]');
      }
      return (matchingValue !== undefined)
        ? ( value.toString() == matchingValue.toString() )
        : false
      ;
    },

    // different than another field
    different: function(value, identifier) {
      // use either id or name of field
      var
        $form = $(this),
        matchingValue
      ;
      if( $('[data-validate="'+ identifier +'"]').length > 0 ) {
        matchingValue = $('[data-validate="'+ identifier +'"]').val();
      }
      else if($('#' + identifier).length > 0) {
        matchingValue = $('#' + identifier).val();
      }
      else if($('[name="' + identifier +'"]').length > 0) {
        matchingValue = $('[name="' + identifier + '"]').val();
      }
      else if( $('[name="' + identifier +'[]"]').length > 0 ) {
        matchingValue = $('[name="' + identifier +'[]"]');
      }
      return (matchingValue !== undefined)
        ? ( value.toString() !== matchingValue.toString() )
        : false
      ;
    },

    creditCard: function(cardNumber, cardTypes) {
      var
        cards = {
          visa: {
            pattern : /^4/,
            length  : [16]
          },
          amex: {
            pattern : /^3[47]/,
            length  : [15]
          },
          mastercard: {
            pattern : /^5[1-5]/,
            length  : [16]
          },
          discover: {
            pattern : /^(6011|622(12[6-9]|1[3-9][0-9]|[2-8][0-9]{2}|9[0-1][0-9]|92[0-5]|64[4-9])|65)/,
            length  : [16]
          },
          unionPay: {
            pattern : /^(62|88)/,
            length  : [16, 17, 18, 19]
          },
          jcb: {
            pattern : /^35(2[89]|[3-8][0-9])/,
            length  : [16]
          },
          maestro: {
            pattern : /^(5018|5020|5038|6304|6759|676[1-3])/,
            length  : [12, 13, 14, 15, 16, 17, 18, 19]
          },
          dinersClub: {
            pattern : /^(30[0-5]|^36)/,
            length  : [14]
          },
          laser: {
            pattern : /^(6304|670[69]|6771)/,
            length  : [16, 17, 18, 19]
          },
          visaElectron: {
            pattern : /^(4026|417500|4508|4844|491(3|7))/,
            length  : [16]
          }
        },
        valid         = {},
        validCard     = false,
        requiredTypes = (typeof cardTypes == 'string')
          ? cardTypes.split(',')
          : false,
        unionPay,
        validation
      ;

      if(typeof cardNumber !== 'string' || cardNumber.length === 0) {
        return;
      }

      // allow dashes in card
      cardNumber = cardNumber.replace(/[\-]/g, '');

      // verify card types
      if(requiredTypes) {
        $.each(requiredTypes, function(index, type){
          // verify each card type
          validation = cards[type];
          if(validation) {
            valid = {
              length  : ($.inArray(cardNumber.length, validation.length) !== -1),
              pattern : (cardNumber.search(validation.pattern) !== -1)
            };
            if(valid.length && valid.pattern) {
              validCard = true;
            }
          }
        });

        if(!validCard) {
          return false;
        }
      }

      // skip luhn for UnionPay
      unionPay = {
        number  : ($.inArray(cardNumber.length, cards.unionPay.length) !== -1),
        pattern : (cardNumber.search(cards.unionPay.pattern) !== -1)
      };
      if(unionPay.number && unionPay.pattern) {
        return true;
      }

      // verify luhn, adapted from  <https://gist.github.com/2134376>
      var
        length        = cardNumber.length,
        multiple      = 0,
        producedValue = [
          [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
          [0, 2, 4, 6, 8, 1, 3, 5, 7, 9]
        ],
        sum           = 0
      ;
      while (length--) {
        sum += producedValue[multiple][parseInt(cardNumber.charAt(length), 10)];
        multiple ^= 1;
      }
      return (sum % 10 === 0 && sum > 0);
    },

    minCount: function(value, minCount) {
      if(minCount == 0) {
        return true;
      }
      if(minCount == 1) {
        return (value !== '');
      }
      return (value.split(',').length >= minCount);
    },

    exactCount: function(value, exactCount) {
      if(exactCount == 0) {
        return (value === '');
      }
      if(exactCount == 1) {
        return (value !== '' && value.search(',') === -1);
      }
      return (value.split(',').length == exactCount);
    },

    maxCount: function(value, maxCount) {
      if(maxCount == 0) {
        return false;
      }
      if(maxCount == 1) {
        return (value.search(',') === -1);
      }
      return (value.split(',').length <= maxCount);
    }
  }

};

})( jQuery, window, document );

/*!
 * # Semantic UI 2.4.2 - Accordion
 * http://github.com/semantic-org/semantic-ui/
 *
 *
 * Released under the MIT license
 * http://opensource.org/licenses/MIT
 *
 */

;(function ($, window, document, undefined) {

'use strict';

window = (typeof window != 'undefined' && window.Math == Math)
  ? window
  : (typeof self != 'undefined' && self.Math == Math)
    ? self
    : Function('return this')()
;

$.fn.accordion = function(parameters) {
  var
    $allModules     = $(this),

    time            = new Date().getTime(),
    performance     = [],

    query           = arguments[0],
    methodInvoked   = (typeof query == 'string'),
    queryArguments  = [].slice.call(arguments, 1),

    requestAnimationFrame = window.requestAnimationFrame
      || window.mozRequestAnimationFrame
      || window.webkitRequestAnimationFrame
      || window.msRequestAnimationFrame
      || function(callback) { setTimeout(callback, 0); },

    returnedValue
  ;
  $allModules
    .each(function() {
      var
        settings        = ( $.isPlainObject(parameters) )
          ? $.extend(true, {}, $.fn.accordion.settings, parameters)
          : $.extend({}, $.fn.accordion.settings),

        className       = settings.className,
        namespace       = settings.namespace,
        selector        = settings.selector,
        error           = settings.error,

        eventNamespace  = '.' + namespace,
        moduleNamespace = 'module-' + namespace,
        moduleSelector  = $allModules.selector || '',

        $module  = $(this),
        $title   = $module.find(selector.title),
        $content = $module.find(selector.content),

        element  = this,
        instance = $module.data(moduleNamespace),
        observer,
        module
      ;

      module = {

        initialize: function() {
          module.debug('Initializing', $module);
          module.bind.events();
          if(settings.observeChanges) {
            module.observeChanges();
          }
          module.instantiate();
        },

        instantiate: function() {
          instance = module;
          $module
            .data(moduleNamespace, module)
          ;
        },

        destroy: function() {
          module.debug('Destroying previous instance', $module);
          $module
            .off(eventNamespace)
            .removeData(moduleNamespace)
          ;
        },

        refresh: function() {
          $title   = $module.find(selector.title);
          $content = $module.find(selector.content);
        },

        observeChanges: function() {
          if('MutationObserver' in window) {
            observer = new MutationObserver(function(mutations) {
              module.debug('DOM tree modified, updating selector cache');
              module.refresh();
            });
            observer.observe(element, {
              childList : true,
              subtree   : true
            });
            module.debug('Setting up mutation observer', observer);
          }
        },

        bind: {
          events: function() {
            module.debug('Binding delegated events');
            $module
              .on(settings.on + eventNamespace, selector.trigger, module.event.click)
            ;
          }
        },

        event: {
          click: function() {
            module.toggle.call(this);
          }
        },

        toggle: function(query) {
          var
            $activeTitle = (query !== undefined)
              ? (typeof query === 'number')
                ? $title.eq(query)
                : $(query).closest(selector.title)
              : $(this).closest(selector.title),
            $activeContent = $activeTitle.next($content),
            isAnimating = $activeContent.hasClass(className.animating),
            isActive    = $activeContent.hasClass(className.active),
            isOpen      = (isActive && !isAnimating),
            isOpening   = (!isActive && isAnimating)
          ;
          module.debug('Toggling visibility of content', $activeTitle);
          if(isOpen || isOpening) {
            if(settings.collapsible) {
              module.close.call($activeTitle);
            }
            else {
              module.debug('Cannot close accordion content collapsing is disabled');
            }
          }
          else {
            module.open.call($activeTitle);
          }
        },

        open: function(query) {
          var
            $activeTitle = (query !== undefined)
              ? (typeof query === 'number')
                ? $title.eq(query)
                : $(query).closest(selector.title)
              : $(this).closest(selector.title),
            $activeContent = $activeTitle.next($content),
            isAnimating = $activeContent.hasClass(className.animating),
            isActive    = $activeContent.hasClass(className.active),
            isOpen      = (isActive || isAnimating)
          ;
          if(isOpen) {
            module.debug('Accordion already open, skipping', $activeContent);
            return;
          }
          module.debug('Opening accordion content', $activeTitle);
          settings.onOpening.call($activeContent);
          settings.onChanging.call($activeContent);
          if(settings.exclusive) {
            module.closeOthers.call($activeTitle);
          }
          $activeTitle
            .addClass(className.active)
          ;
          $activeContent
            .stop(true, true)
            .addClass(className.animating)
          ;
          if(settings.animateChildren) {
            if($.fn.transition !== undefined && $module.transition('is supported')) {
              $activeContent
                .children()
                  .transition({
                    animation   : 'fade in',
                    queue       : false,
                    useFailSafe : true,
                    debug       : settings.debug,
                    verbose     : settings.verbose,
                    duration    : settings.duration
                  })
              ;
            }
            else {
              $activeContent
                .children()
                  .stop(true, true)
                  .animate({
                    opacity: 1
                  }, settings.duration, module.resetOpacity)
              ;
            }
          }
          $activeContent
            .slideDown(settings.duration, settings.easing, function() {
              $activeContent
                .removeClass(className.animating)
                .addClass(className.active)
              ;
              module.reset.display.call(this);
              settings.onOpen.call(this);
              settings.onChange.call(this);
            })
          ;
        },

        close: function(query) {
          var
            $activeTitle = (query !== undefined)
              ? (typeof query === 'number')
                ? $title.eq(query)
                : $(query).closest(selector.title)
              : $(this).closest(selector.title),
            $activeContent = $activeTitle.next($content),
            isAnimating    = $activeContent.hasClass(className.animating),
            isActive       = $activeContent.hasClass(className.active),
            isOpening      = (!isActive && isAnimating),
            isClosing      = (isActive && isAnimating)
          ;
          if((isActive || isOpening) && !isClosing) {
            module.debug('Closing accordion content', $activeContent);
            settings.onClosing.call($activeContent);
            settings.onChanging.call($activeContent);
            $activeTitle
              .removeClass(className.active)
            ;
            $activeContent
              .stop(true, true)
              .addClass(className.animating)
            ;
            if(settings.animateChildren) {
              if($.fn.transition !== undefined && $module.transition('is supported')) {
                $activeContent
                  .children()
                    .transition({
                      animation   : 'fade out',
                      queue       : false,
                      useFailSafe : true,
                      debug       : settings.debug,
                      verbose     : settings.verbose,
                      duration    : settings.duration
                    })
                ;
              }
              else {
                $activeContent
                  .children()
                    .stop(true, true)
                    .animate({
                      opacity: 0
                    }, settings.duration, module.resetOpacity)
                ;
              }
            }
            $activeContent
              .slideUp(settings.duration, settings.easing, function() {
                $activeContent
                  .removeClass(className.animating)
                  .removeClass(className.active)
                ;
                module.reset.display.call(this);
                settings.onClose.call(this);
                settings.onChange.call(this);
              })
            ;
          }
        },

        closeOthers: function(index) {
          var
            $activeTitle = (index !== undefined)
              ? $title.eq(index)
              : $(this).closest(selector.title),
            $parentTitles    = $activeTitle.parents(selector.content).prev(selector.title),
            $activeAccordion = $activeTitle.closest(selector.accordion),
            activeSelector   = selector.title + '.' + className.active + ':visible',
            activeContent    = selector.content + '.' + className.active + ':visible',
            $openTitles,
            $nestedTitles,
            $openContents
          ;
          if(settings.closeNested) {
            $openTitles   = $activeAccordion.find(activeSelector).not($parentTitles);
            $openContents = $openTitles.next($content);
          }
          else {
            $openTitles   = $activeAccordion.find(activeSelector).not($parentTitles);
            $nestedTitles = $activeAccordion.find(activeContent).find(activeSelector).not($parentTitles);
            $openTitles   = $openTitles.not($nestedTitles);
            $openContents = $openTitles.next($content);
          }
          if( ($openTitles.length > 0) ) {
            module.debug('Exclusive enabled, closing other content', $openTitles);
            $openTitles
              .removeClass(className.active)
            ;
            $openContents
              .removeClass(className.animating)
              .stop(true, true)
            ;
            if(settings.animateChildren) {
              if($.fn.transition !== undefined && $module.transition('is supported')) {
                $openContents
                  .children()
                    .transition({
                      animation   : 'fade out',
                      useFailSafe : true,
                      debug       : settings.debug,
                      verbose     : settings.verbose,
                      duration    : settings.duration
                    })
                ;
              }
              else {
                $openContents
                  .children()
                    .stop(true, true)
                    .animate({
                      opacity: 0
                    }, settings.duration, module.resetOpacity)
                ;
              }
            }
            $openContents
              .slideUp(settings.duration , settings.easing, function() {
                $(this).removeClass(className.active);
                module.reset.display.call(this);
              })
            ;
          }
        },

        reset: {

          display: function() {
            module.verbose('Removing inline display from element', this);
            $(this).css('display', '');
            if( $(this).attr('style') === '') {
              $(this)
                .attr('style', '')
                .removeAttr('style')
              ;
            }
          },

          opacity: function() {
            module.verbose('Removing inline opacity from element', this);
            $(this).css('opacity', '');
            if( $(this).attr('style') === '') {
              $(this)
                .attr('style', '')
                .removeAttr('style')
              ;
            }
          },

        },

        setting: function(name, value) {
          module.debug('Changing setting', name, value);
          if( $.isPlainObject(name) ) {
            $.extend(true, settings, name);
          }
          else if(value !== undefined) {
            if($.isPlainObject(settings[name])) {
              $.extend(true, settings[name], value);
            }
            else {
              settings[name] = value;
            }
          }
          else {
            return settings[name];
          }
        },
        internal: function(name, value) {
          module.debug('Changing internal', name, value);
          if(value !== undefined) {
            if( $.isPlainObject(name) ) {
              $.extend(true, module, name);
            }
            else {
              module[name] = value;
            }
          }
          else {
            return module[name];
          }
        },
        debug: function() {
          if(!settings.silent && settings.debug) {
            if(settings.performance) {
              module.performance.log(arguments);
            }
            else {
              module.debug = Function.prototype.bind.call(console.info, console, settings.name + ':');
              module.debug.apply(console, arguments);
            }
          }
        },
        verbose: function() {
          if(!settings.silent && settings.verbose && settings.debug) {
            if(settings.performance) {
              module.performance.log(arguments);
            }
            else {
              module.verbose = Function.prototype.bind.call(console.info, console, settings.name + ':');
              module.verbose.apply(console, arguments);
            }
          }
        },
        error: function() {
          if(!settings.silent) {
            module.error = Function.prototype.bind.call(console.error, console, settings.name + ':');
            module.error.apply(console, arguments);
          }
        },
        performance: {
          log: function(message) {
            var
              currentTime,
              executionTime,
              previousTime
            ;
            if(settings.performance) {
              currentTime   = new Date().getTime();
              previousTime  = time || currentTime;
              executionTime = currentTime - previousTime;
              time          = currentTime;
              performance.push({
                'Name'           : message[0],
                'Arguments'      : [].slice.call(message, 1) || '',
                'Element'        : element,
                'Execution Time' : executionTime
              });
            }
            clearTimeout(module.performance.timer);
            module.performance.timer = setTimeout(module.performance.display, 500);
          },
          display: function() {
            var
              title = settings.name + ':',
              totalTime = 0
            ;
            time = false;
            clearTimeout(module.performance.timer);
            $.each(performance, function(index, data) {
              totalTime += data['Execution Time'];
            });
            title += ' ' + totalTime + 'ms';
            if(moduleSelector) {
              title += ' \'' + moduleSelector + '\'';
            }
            if( (console.group !== undefined || console.table !== undefined) && performance.length > 0) {
              console.groupCollapsed(title);
              if(console.table) {
                console.table(performance);
              }
              else {
                $.each(performance, function(index, data) {
                  console.log(data['Name'] + ': ' + data['Execution Time']+'ms');
                });
              }
              console.groupEnd();
            }
            performance = [];
          }
        },
        invoke: function(query, passedArguments, context) {
          var
            object = instance,
            maxDepth,
            found,
            response
          ;
          passedArguments = passedArguments || queryArguments;
          context         = element         || context;
          if(typeof query == 'string' && object !== undefined) {
            query    = query.split(/[\. ]/);
            maxDepth = query.length - 1;
            $.each(query, function(depth, value) {
              var camelCaseValue = (depth != maxDepth)
                ? value + query[depth + 1].charAt(0).toUpperCase() + query[depth + 1].slice(1)
                : query
              ;
              if( $.isPlainObject( object[camelCaseValue] ) && (depth != maxDepth) ) {
                object = object[camelCaseValue];
              }
              else if( object[camelCaseValue] !== undefined ) {
                found = object[camelCaseValue];
                return false;
              }
              else if( $.isPlainObject( object[value] ) && (depth != maxDepth) ) {
                object = object[value];
              }
              else if( object[value] !== undefined ) {
                found = object[value];
                return false;
              }
              else {
                module.error(error.method, query);
                return false;
              }
            });
          }
          if ( $.isFunction( found ) ) {
            response = found.apply(context, passedArguments);
          }
          else if(found !== undefined) {
            response = found;
          }
          if($.isArray(returnedValue)) {
            returnedValue.push(response);
          }
          else if(returnedValue !== undefined) {
            returnedValue = [returnedValue, response];
          }
          else if(response !== undefined) {
            returnedValue = response;
          }
          return found;
        }
      };
      if(methodInvoked) {
        if(instance === undefined) {
          module.initialize();
        }
        module.invoke(query);
      }
      else {
        if(instance !== undefined) {
          instance.invoke('destroy');
        }
        module.initialize();
      }
    })
  ;
  return (returnedValue !== undefined)
    ? returnedValue
    : this
  ;
};

$.fn.accordion.settings = {

  name            : 'Accordion',
  namespace       : 'accordion',

  silent          : false,
  debug           : false,
  verbose         : false,
  performance     : true,

  on              : 'click', // event on title that opens accordion

  observeChanges  : true,  // whether accordion should automatically refresh on DOM insertion

  exclusive       : true,  // whether a single accordion content panel should be open at once
  collapsible     : true,  // whether accordion content can be closed
  closeNested     : false, // whether nested content should be closed when a panel is closed
  animateChildren : true,  // whether children opacity should be animated

  duration        : 350, // duration of animation
  easing          : 'easeOutQuad', // easing equation for animation

  onOpening       : function(){}, // callback before open animation
  onClosing       : function(){}, // callback before closing animation
  onChanging      : function(){}, // callback before closing or opening animation

  onOpen          : function(){}, // callback after open animation
  onClose         : function(){}, // callback after closing animation
  onChange        : function(){}, // callback after closing or opening animation

  error: {
    method : 'The method you called is not defined'
  },

  className   : {
    active    : 'active',
    animating : 'animating'
  },

  selector    : {
    accordion : '.accordion',
    title     : '.title',
    trigger   : '.title',
    content   : '.content'
  }

};

// Adds easing
$.extend( $.easing, {
  easeOutQuad: function (x, t, b, c, d) {
    return -c *(t/=d)*(t-2) + b;
  }
});

})( jQuery, window, document );


/*!
 * # Semantic UI 2.4.2 - Dimmer
 * http://github.com/semantic-org/semantic-ui/
 *
 *
 * Released under the MIT license
 * http://opensource.org/licenses/MIT
 *
 */

;(function ($, window, document, undefined) {

'use strict';

window = (typeof window != 'undefined' && window.Math == Math)
  ? window
  : (typeof self != 'undefined' && self.Math == Math)
    ? self
    : Function('return this')()
;

$.fn.dimmer = function(parameters) {
  var
    $allModules     = $(this),

    time            = new Date().getTime(),
    performance     = [],

    query           = arguments[0],
    methodInvoked   = (typeof query == 'string'),
    queryArguments  = [].slice.call(arguments, 1),

    returnedValue
  ;

  $allModules
    .each(function() {
      var
        settings        = ( $.isPlainObject(parameters) )
          ? $.extend(true, {}, $.fn.dimmer.settings, parameters)
          : $.extend({}, $.fn.dimmer.settings),

        selector        = settings.selector,
        namespace       = settings.namespace,
        className       = settings.className,
        error           = settings.error,

        eventNamespace  = '.' + namespace,
        moduleNamespace = 'module-' + namespace,
        moduleSelector  = $allModules.selector || '',

        clickEvent      = ('ontouchstart' in document.documentElement)
          ? 'touchstart'
          : 'click',

        $module = $(this),
        $dimmer,
        $dimmable,

        element   = this,
        instance  = $module.data(moduleNamespace),
        module
      ;

      module = {

        preinitialize: function() {
          if( module.is.dimmer() ) {

            $dimmable = $module.parent();
            $dimmer   = $module;
          }
          else {
            $dimmable = $module;
            if( module.has.dimmer() ) {
              if(settings.dimmerName) {
                $dimmer = $dimmable.find(selector.dimmer).filter('.' + settings.dimmerName);
              }
              else {
                $dimmer = $dimmable.find(selector.dimmer);
              }
            }
            else {
              $dimmer = module.create();
            }
          }
        },

        initialize: function() {
          module.debug('Initializing dimmer', settings);

          module.bind.events();
          module.set.dimmable();
          module.instantiate();
        },

        instantiate: function() {
          module.verbose('Storing instance of module', module);
          instance = module;
          $module
            .data(moduleNamespace, instance)
          ;
        },

        destroy: function() {
          module.verbose('Destroying previous module', $dimmer);
          module.unbind.events();
          module.remove.variation();
          $dimmable
            .off(eventNamespace)
          ;
        },

        bind: {
          events: function() {
            if(settings.on == 'hover') {
              $dimmable
                .on('mouseenter' + eventNamespace, module.show)
                .on('mouseleave' + eventNamespace, module.hide)
              ;
            }
            else if(settings.on == 'click') {
              $dimmable
                .on(clickEvent + eventNamespace, module.toggle)
              ;
            }
            if( module.is.page() ) {
              module.debug('Setting as a page dimmer', $dimmable);
              module.set.pageDimmer();
            }

            if( module.is.closable() ) {
              module.verbose('Adding dimmer close event', $dimmer);
              $dimmable
                .on(clickEvent + eventNamespace, selector.dimmer, module.event.click)
              ;
            }
          }
        },

        unbind: {
          events: function() {
            $module
              .removeData(moduleNamespace)
            ;
            $dimmable
              .off(eventNamespace)
            ;
          }
        },

        event: {
          click: function(event) {
            module.verbose('Determining if event occured on dimmer', event);
            if( $dimmer.find(event.target).length === 0 || $(event.target).is(selector.content) ) {
              module.hide();
              event.stopImmediatePropagation();
            }
          },
        },

        addContent: function(element) {
          var
            $content = $(element)
          ;
          module.debug('Add content to dimmer', $content);
          if($content.parent()[0] !== $dimmer[0]) {
            $content.detach().appendTo($dimmer);
          }
        },

        create: function() {
          var
            $element = $( settings.template.dimmer() )
          ;
          if(settings.dimmerName) {
            module.debug('Creating named dimmer', settings.dimmerName);
            $element.addClass(settings.dimmerName);
          }
          $element
            .appendTo($dimmable)
          ;
          return $element;
        },

        show: function(callback) {
          callback = $.isFunction(callback)
            ? callback
            : function(){}
          ;
          module.debug('Showing dimmer', $dimmer, settings);
          module.set.variation();
          if( (!module.is.dimmed() || module.is.animating()) && module.is.enabled() ) {
            module.animate.show(callback);
            settings.onShow.call(element);
            settings.onChange.call(element);
          }
          else {
            module.debug('Dimmer is already shown or disabled');
          }
        },

        hide: function(callback) {
          callback = $.isFunction(callback)
            ? callback
            : function(){}
          ;
          if( module.is.dimmed() || module.is.animating() ) {
            module.debug('Hiding dimmer', $dimmer);
            module.animate.hide(callback);
            settings.onHide.call(element);
            settings.onChange.call(element);
          }
          else {
            module.debug('Dimmer is not visible');
          }
        },

        toggle: function() {
          module.verbose('Toggling dimmer visibility', $dimmer);
          if( !module.is.dimmed() ) {
            module.show();
          }
          else {
            module.hide();
          }
        },

        animate: {
          show: function(callback) {
            callback = $.isFunction(callback)
              ? callback
              : function(){}
            ;
            if(settings.useCSS && $.fn.transition !== undefined && $dimmer.transition('is supported')) {
              if(settings.useFlex) {
                module.debug('Using flex dimmer');
                module.remove.legacy();
              }
              else {
                module.debug('Using legacy non-flex dimmer');
                module.set.legacy();
              }
              if(settings.opacity !== 'auto') {
                module.set.opacity();
              }
              $dimmer
                .transition({
                  displayType : settings.useFlex
                    ? 'flex'
                    : 'block',
                  animation   : settings.transition + ' in',
                  queue       : false,
                  duration    : module.get.duration(),
                  useFailSafe : true,
                  onStart     : function() {
                    module.set.dimmed();
                  },
                  onComplete  : function() {
                    module.set.active();
                    callback();
                  }
                })
              ;
            }
            else {
              module.verbose('Showing dimmer animation with javascript');
              module.set.dimmed();
              if(settings.opacity == 'auto') {
                settings.opacity = 0.8;
              }
              $dimmer
                .stop()
                .css({
                  opacity : 0,
                  width   : '100%',
                  height  : '100%'
                })
                .fadeTo(module.get.duration(), settings.opacity, function() {
                  $dimmer.removeAttr('style');
                  module.set.active();
                  callback();
                })
              ;
            }
          },
          hide: function(callback) {
            callback = $.isFunction(callback)
              ? callback
              : function(){}
            ;
            if(settings.useCSS && $.fn.transition !== undefined && $dimmer.transition('is supported')) {
              module.verbose('Hiding dimmer with css');
              $dimmer
                .transition({
                  displayType : settings.useFlex
                    ? 'flex'
                    : 'block',
                  animation   : settings.transition + ' out',
                  queue       : false,
                  duration    : module.get.duration(),
                  useFailSafe : true,
                  onStart     : function() {
                    module.remove.dimmed();
                  },
                  onComplete  : function() {
                    module.remove.variation();
                    module.remove.active();
                    callback();
                  }
                })
              ;
            }
            else {
              module.verbose('Hiding dimmer with javascript');
              module.remove.dimmed();
              $dimmer
                .stop()
                .fadeOut(module.get.duration(), function() {
                  module.remove.active();
                  $dimmer.removeAttr('style');
                  callback();
                })
              ;
            }
          }
        },

        get: {
          dimmer: function() {
            return $dimmer;
          },
          duration: function() {
            if(typeof settings.duration == 'object') {
              if( module.is.active() ) {
                return settings.duration.hide;
              }
              else {
                return settings.duration.show;
              }
            }
            return settings.duration;
          }
        },

        has: {
          dimmer: function() {
            if(settings.dimmerName) {
              return ($module.find(selector.dimmer).filter('.' + settings.dimmerName).length > 0);
            }
            else {
              return ( $module.find(selector.dimmer).length > 0 );
            }
          }
        },

        is: {
          active: function() {
            return $dimmer.hasClass(className.active);
          },
          animating: function() {
            return ( $dimmer.is(':animated') || $dimmer.hasClass(className.animating) );
          },
          closable: function() {
            if(settings.closable == 'auto') {
              if(settings.on == 'hover') {
                return false;
              }
              return true;
            }
            return settings.closable;
          },
          dimmer: function() {
            return $module.hasClass(className.dimmer);
          },
          dimmable: function() {
            return $module.hasClass(className.dimmable);
          },
          dimmed: function() {
            return $dimmable.hasClass(className.dimmed);
          },
          disabled: function() {
            return $dimmable.hasClass(className.disabled);
          },
          enabled: function() {
            return !module.is.disabled();
          },
          page: function () {
            return $dimmable.is('body');
          },
          pageDimmer: function() {
            return $dimmer.hasClass(className.pageDimmer);
          }
        },

        can: {
          show: function() {
            return !$dimmer.hasClass(className.disabled);
          }
        },

        set: {
          opacity: function(opacity) {
            var
              color      = $dimmer.css('background-color'),
              colorArray = color.split(','),
              isRGB      = (colorArray && colorArray.length == 3),
              isRGBA     = (colorArray && colorArray.length == 4)
            ;
            opacity    = settings.opacity === 0 ? 0 : settings.opacity || opacity;
            if(isRGB || isRGBA) {
              colorArray[3] = opacity + ')';
              color         = colorArray.join(',');
            }
            else {
              color = 'rgba(0, 0, 0, ' + opacity + ')';
            }
            module.debug('Setting opacity to', opacity);
            $dimmer.css('background-color', color);
          },
          legacy: function() {
            $dimmer.addClass(className.legacy);
          },
          active: function() {
            $dimmer.addClass(className.active);
          },
          dimmable: function() {
            $dimmable.addClass(className.dimmable);
          },
          dimmed: function() {
            $dimmable.addClass(className.dimmed);
          },
          pageDimmer: function() {
            $dimmer.addClass(className.pageDimmer);
          },
          disabled: function() {
            $dimmer.addClass(className.disabled);
          },
          variation: function(variation) {
            variation = variation || settings.variation;
            if(variation) {
              $dimmer.addClass(variation);
            }
          }
        },

        remove: {
          active: function() {
            $dimmer
              .removeClass(className.active)
            ;
          },
          legacy: function() {
            $dimmer.removeClass(className.legacy);
          },
          dimmed: function() {
            $dimmable.removeClass(className.dimmed);
          },
          disabled: function() {
            $dimmer.removeClass(className.disabled);
          },
          variation: function(variation) {
            variation = variation || settings.variation;
            if(variation) {
              $dimmer.removeClass(variation);
            }
          }
        },

        setting: function(name, value) {
          module.debug('Changing setting', name, value);
          if( $.isPlainObject(name) ) {
            $.extend(true, settings, name);
          }
          else if(value !== undefined) {
            if($.isPlainObject(settings[name])) {
              $.extend(true, settings[name], value);
            }
            else {
              settings[name] = value;
            }
          }
          else {
            return settings[name];
          }
        },
        internal: function(name, value) {
          if( $.isPlainObject(name) ) {
            $.extend(true, module, name);
          }
          else if(value !== undefined) {
            module[name] = value;
          }
          else {
            return module[name];
          }
        },
        debug: function() {
          if(!settings.silent && settings.debug) {
            if(settings.performance) {
              module.performance.log(arguments);
            }
            else {
              module.debug = Function.prototype.bind.call(console.info, console, settings.name + ':');
              module.debug.apply(console, arguments);
            }
          }
        },
        verbose: function() {
          if(!settings.silent && settings.verbose && settings.debug) {
            if(settings.performance) {
              module.performance.log(arguments);
            }
            else {
              module.verbose = Function.prototype.bind.call(console.info, console, settings.name + ':');
              module.verbose.apply(console, arguments);
            }
          }
        },
        error: function() {
          if(!settings.silent) {
            module.error = Function.prototype.bind.call(console.error, console, settings.name + ':');
            module.error.apply(console, arguments);
          }
        },
        performance: {
          log: function(message) {
            var
              currentTime,
              executionTime,
              previousTime
            ;
            if(settings.performance) {
              currentTime   = new Date().getTime();
              previousTime  = time || currentTime;
              executionTime = currentTime - previousTime;
              time          = currentTime;
              performance.push({
                'Name'           : message[0],
                'Arguments'      : [].slice.call(message, 1) || '',
                'Element'        : element,
                'Execution Time' : executionTime
              });
            }
            clearTimeout(module.performance.timer);
            module.performance.timer = setTimeout(module.performance.display, 500);
          },
          display: function() {
            var
              title = settings.name + ':',
              totalTime = 0
            ;
            time = false;
            clearTimeout(module.performance.timer);
            $.each(performance, function(index, data) {
              totalTime += data['Execution Time'];
            });
            title += ' ' + totalTime + 'ms';
            if(moduleSelector) {
              title += ' \'' + moduleSelector + '\'';
            }
            if($allModules.length > 1) {
              title += ' ' + '(' + $allModules.length + ')';
            }
            if( (console.group !== undefined || console.table !== undefined) && performance.length > 0) {
              console.groupCollapsed(title);
              if(console.table) {
                console.table(performance);
              }
              else {
                $.each(performance, function(index, data) {
                  console.log(data['Name'] + ': ' + data['Execution Time']+'ms');
                });
              }
              console.groupEnd();
            }
            performance = [];
          }
        },
        invoke: function(query, passedArguments, context) {
          var
            object = instance,
            maxDepth,
            found,
            response
          ;
          passedArguments = passedArguments || queryArguments;
          context         = element         || context;
          if(typeof query == 'string' && object !== undefined) {
            query    = query.split(/[\. ]/);
            maxDepth = query.length - 1;
            $.each(query, function(depth, value) {
              var camelCaseValue = (depth != maxDepth)
                ? value + query[depth + 1].charAt(0).toUpperCase() + query[depth + 1].slice(1)
                : query
              ;
              if( $.isPlainObject( object[camelCaseValue] ) && (depth != maxDepth) ) {
                object = object[camelCaseValue];
              }
              else if( object[camelCaseValue] !== undefined ) {
                found = object[camelCaseValue];
                return false;
              }
              else if( $.isPlainObject( object[value] ) && (depth != maxDepth) ) {
                object = object[value];
              }
              else if( object[value] !== undefined ) {
                found = object[value];
                return false;
              }
              else {
                module.error(error.method, query);
                return false;
              }
            });
          }
          if ( $.isFunction( found ) ) {
            response = found.apply(context, passedArguments);
          }
          else if(found !== undefined) {
            response = found;
          }
          if($.isArray(returnedValue)) {
            returnedValue.push(response);
          }
          else if(returnedValue !== undefined) {
            returnedValue = [returnedValue, response];
          }
          else if(response !== undefined) {
            returnedValue = response;
          }
          return found;
        }
      };

      module.preinitialize();

      if(methodInvoked) {
        if(instance === undefined) {
          module.initialize();
        }
        module.invoke(query);
      }
      else {
        if(instance !== undefined) {
          instance.invoke('destroy');
        }
        module.initialize();
      }
    })
  ;

  return (returnedValue !== undefined)
    ? returnedValue
    : this
  ;
};

$.fn.dimmer.settings = {

  name        : 'Dimmer',
  namespace   : 'dimmer',

  silent      : false,
  debug       : false,
  verbose     : false,
  performance : true,

  // whether should use flex layout
  useFlex     : true,

  // name to distinguish between multiple dimmers in context
  dimmerName  : false,

  // whether to add a variation type
  variation   : false,

  // whether to bind close events
  closable    : 'auto',

  // whether to use css animations
  useCSS      : true,

  // css animation to use
  transition  : 'fade',

  // event to bind to
  on          : false,

  // overriding opacity value
  opacity     : 'auto',

  // transition durations
  duration    : {
    show : 500,
    hide : 500
  },

  onChange    : function(){},
  onShow      : function(){},
  onHide      : function(){},

  error   : {
    method   : 'The method you called is not defined.'
  },

  className : {
    active     : 'active',
    animating  : 'animating',
    dimmable   : 'dimmable',
    dimmed     : 'dimmed',
    dimmer     : 'dimmer',
    disabled   : 'disabled',
    hide       : 'hide',
    legacy     : 'legacy',
    pageDimmer : 'page',
    show       : 'show'
  },

  selector: {
    dimmer   : '> .ui.dimmer',
    content  : '.ui.dimmer > .content, .ui.dimmer > .content > .center'
  },

  template: {
    dimmer: function() {
     return $('<div />').attr('class', 'ui dimmer');
    }
  }

};

})( jQuery, window, document );

/*!
 * # Semantic UI 2.4.2 - Dropdown
 * http://github.com/semantic-org/semantic-ui/
 *
 *
 * Released under the MIT license
 * http://opensource.org/licenses/MIT
 *
 */

(function($, window, document, undefined) {
	"use strict";

	window =
		typeof window != "undefined" && window.Math == Math
			? window
			: typeof self != "undefined" && self.Math == Math
			? self
			: Function("return this")();

	$.fn.dropdownX = function(parameters) {
		var $allModules = $(this),
			$document = $(document),
			moduleSelector = $allModules.selector || "",
			hasTouch = "ontouchstart" in document.documentElement,
			time = new Date().getTime(),
			performance = [],
			query = arguments[0],
			methodInvoked = typeof query == "string",
			queryArguments = [].slice.call(arguments, 1),
			returnedValue;

		$allModules.each(function(elementIndex) {
			var settings = $.isPlainObject(parameters)
					? $.extend(true, {}, $.fn.dropdownX.settings, parameters)
					: $.extend({}, $.fn.dropdownX.settings),
				className = settings.className,
				message = settings.message,
				fields = settings.fields,
				keys = settings.keys,
				metadata = settings.metadata,
				namespace = settings.namespace,
				regExp = settings.regExp,
				selector = settings.selector,
				error = settings.error,
				templates = settings.templates,
				eventNamespace = "." + namespace,
				moduleNamespace = "module-" + namespace,
				$module = $(this),
				$context = $(settings.context),
				$text = $module.find(selector.text),
				$search = $module.find(selector.search),
				$sizer = $module.find(selector.sizer),
				$input = $module.find(selector.input),
				$icon = $module.find(selector.icon),
				$combo =
					$module.prev().find(selector.text).length > 0
						? $module.prev().find(selector.text)
						: $module.prev(),
				$menu = $module.children(selector.menu),
				$item = $menu.find(selector.item),
				activated = false,
				itemActivated = false,
				internalChange = false,
				element = this,
				instance = $module.data(moduleNamespace),
				initialLoad,
				pageLostFocus,
				willRefocus,
				elementNamespace,
				id,
				selectObserver,
				menuObserver,
				module;

			module = {
				initialize: function() {
					module.debug("Initializing dropdown", settings);

					if (module.is.alreadySetup()) {
						module.setup.reference();
					} else {
						module.setup.layout();

						if (settings.values) {
							module.change.values(settings.values);
						}

						module.refreshData();

						module.save.defaults();
						module.restore.selected();

						module.create.id();
						module.bind.events();

						module.observeChanges();
						module.instantiate();
					}
				},

				instantiate: function() {
					module.verbose("Storing instance of dropdown", module);
					instance = module;
					$module.data(moduleNamespace, module);
				},

				destroy: function() {
					module.verbose("Destroying previous dropdown", $module);
					module.remove.tabbable();
					$module.off(eventNamespace).removeData(moduleNamespace);
					$menu.off(eventNamespace);
					$document.off(elementNamespace);
					module.disconnect.menuObserver();
					module.disconnect.selectObserver();
				},

				observeChanges: function() {
					if ("MutationObserver" in window) {
						selectObserver = new MutationObserver(
							module.event.select.mutation
						);
						menuObserver = new MutationObserver(
							module.event.menu.mutation
						);
						module.debug(
							"Setting up mutation observer",
							selectObserver,
							menuObserver
						);
						module.observe.select();
						module.observe.menu();
					}
				},

				disconnect: {
					menuObserver: function() {
						if (menuObserver) {
							menuObserver.disconnect();
						}
					},
					selectObserver: function() {
						if (selectObserver) {
							selectObserver.disconnect();
						}
					}
				},
				observe: {
					select: function() {
						if (module.has.input()) {
							selectObserver.observe($module[0], {
								childList: true,
								subtree: true
							});
						}
					},
					menu: function() {
						if (module.has.menu()) {
							menuObserver.observe($menu[0], {
								childList: true,
								subtree: true
							});
						}
					}
				},

				create: {
					id: function() {
						id = (Math.random().toString(16) + "000000000").substr(
							2,
							8
						);
						elementNamespace = "." + id;
						module.verbose("Creating unique id for element", id);
					},
					userChoice: function(values) {
						var $userChoices, $userChoice, isUserValue, html;
						values = values || module.get.userValues();
						if (!values) {
							return false;
						}
						values = $.isArray(values) ? values : [values];
						$.each(values, function(index, value) {
							if (module.get.item(value) === false) {
								html = settings.templates.addition(
									module.add.variables(
										message.addResult,
										value
									)
								);
								$userChoice = $("<div />")
									.html(html)
									.attr("data-" + metadata.value, value)
									.attr("data-" + metadata.text, value)
									.addClass(className.addition)
									.addClass(className.item);
								if (settings.hideAdditions) {
									$userChoice.addClass(className.hidden);
								}
								$userChoices =
									$userChoices === undefined
										? $userChoice
										: $userChoices.add($userChoice);
								module.verbose(
									"Creating user choices for value",
									value,
									$userChoice
								);
							}
						});
						return $userChoices;
					},
					userLabels: function(value) {
						var userValues = module.get.userValues();
						if (userValues) {
							module.debug("Adding user labels", userValues);
							$.each(userValues, function(index, value) {
								module.verbose("Adding custom user value");
								module.add.label(value, value);
							});
						}
					},
					menu: function() {
						$menu = $("<div />")
							.addClass(className.menu)
							.appendTo($module);
					},
					sizer: function() {
						$sizer = $("<span />")
							.addClass(className.sizer)
							.insertAfter($search);
					}
				},

				search: function(query) {
					query = query !== undefined ? query : module.get.query();
					module.verbose("Searching for query", query);
					if (module.has.minCharacters(query)) {
						module.filter(query);
					} else {
						module.hide();
					}
				},

				select: {
					firstUnfiltered: function() {
						module.verbose("Selecting first non-filtered element");
						module.remove.selectedItem();
						$item
							.not(selector.unselectable)
							.not(selector.addition + selector.hidden)
							.eq(0)
							.addClass(className.selected);
					},
					nextAvailable: function($selected) {
						$selected = $selected.eq(0);
						var $nextAvailable = $selected
								.nextAll(selector.item)
								.not(selector.unselectable)
								.eq(0),
							$prevAvailable = $selected
								.prevAll(selector.item)
								.not(selector.unselectable)
								.eq(0),
							hasNext = $nextAvailable.length > 0;
						if (hasNext) {
							module.verbose(
								"Moving selection to",
								$nextAvailable
							);
							$nextAvailable.addClass(className.selected);
						} else {
							module.verbose(
								"Moving selection to",
								$prevAvailable
							);
							$prevAvailable.addClass(className.selected);
						}
					}
				},

				setup: {
					api: function() {
						var apiSettings = {
							debug: settings.debug,
							urlData: {
								value: module.get.value(),
								query: module.get.query()
							},
							on: false
						};
						module.verbose("First request, initializing API");
						$module.api(apiSettings);
					},
					layout: function() {
						if ($module.is("select")) {
							module.setup.select();
							module.setup.returnedObject();
						}
						if (!module.has.menu()) {
							module.create.menu();
						}
						if (module.is.search() && !module.has.search()) {
							module.verbose("Adding search input");
							$search = $("<input />")
								.addClass(className.search)
								.prop("autocomplete", "off")
								.insertBefore($text);
						}
						if (
							module.is.multiple() &&
							module.is.searchSelection() &&
							!module.has.sizer()
						) {
							module.create.sizer();
						}
						if (settings.allowTab) {
							module.set.tabbable();
						}
					},
					select: function() {
						var selectValues = module.get.selectValues();
						module.debug(
							"Dropdown initialized on a select",
							selectValues
						);
						if ($module.is("select")) {
							$input = $module;
						}
						// see if select is placed correctly already
						if ($input.parent(selector.dropdown).length > 0) {
							module.debug(
								"UI dropdown already exists. Creating dropdown menu only"
							);
							$module = $input.closest(selector.dropdown);
							if (!module.has.menu()) {
								module.create.menu();
							}
							$menu = $module.children(selector.menu);
							module.setup.menu(selectValues);
						} else {
							module.debug(
								"Creating entire dropdown from select"
							);
							$module = $("<div />")
								.attr("class", $input.attr("class"))
								.addClass(className.selection)
								.addClass(className.dropdown)
								.html(templates.dropdown(selectValues))
								.insertBefore($input);
							if (
								$input.hasClass(className.multiple) &&
								$input.prop("multiple") === false
							) {
								module.error(error.missingMultiple);
								$input.prop("multiple", true);
							}
							if ($input.is("[multiple]")) {
								module.set.multiple();
							}
							if ($input.prop("disabled")) {
								module.debug("Disabling dropdown");
								$module.addClass(className.disabled);
							}
							$input
								.removeAttr("class")
								.detach()
								.prependTo($module);
						}
						module.refresh();
					},
					menu: function(values) {
						$menu.html(templates.menu(values, fields));
						$item = $menu.find(selector.item);
					},
					reference: function() {
						module.debug(
							"Dropdown behavior was called on select, replacing with closest dropdown"
						);
						// replace module reference
						$module = $module.parent(selector.dropdown);
						instance = $module.data(moduleNamespace);
						element = $module.get(0);
						module.refresh();
						module.setup.returnedObject();
					},
					returnedObject: function() {
						var $firstModules = $allModules.slice(0, elementIndex),
							$lastModules = $allModules.slice(elementIndex + 1);
						// adjust all modules to use correct reference
						$allModules = $firstModules
							.add($module)
							.add($lastModules);
					}
				},

				refresh: function() {
					module.refreshSelectors();
					module.refreshData();
				},

				refreshItems: function() {
					$item = $menu.find(selector.item);
				},

				refreshSelectors: function() {
					module.verbose("Refreshing selector cache");
					$text = $module.find(selector.text);
					$search = $module.find(selector.search);
					$input = $module.find(selector.input);
					$icon = $module.find(selector.icon);
					$combo =
						$module.prev().find(selector.text).length > 0
							? $module.prev().find(selector.text)
							: $module.prev();
					$menu = $module.children(selector.menu);
					$item = $menu.find(selector.item);
				},

				refreshData: function() {
					module.verbose("Refreshing cached metadata");
					$item.removeData(metadata.text).removeData(metadata.value);
				},

				clearData: function() {
					module.verbose("Clearing metadata");
					$item.removeData(metadata.text).removeData(metadata.value);
					$module
						.removeData(metadata.defaultText)
						.removeData(metadata.defaultValue)
						.removeData(metadata.placeholderText);
				},

				toggle: function() {
					module.verbose("Toggling menu visibility");
					if (!module.is.active()) {
						module.show();
					} else {
						module.hide();
					}
				},

				show: function(callback) {
					callback = $.isFunction(callback)
						? callback
						: function() {};
					if (!module.can.show() && module.is.remote()) {
						module.debug(
							"No API results retrieved, searching before show"
						);
						module.queryRemote(module.get.query(), module.show);
					}
					if (module.can.show() && !module.is.active()) {
						module.debug("Showing dropdown");
						if (
							module.has.message() &&
							!(
								module.has.maxSelections() ||
								module.has.allResultsFiltered()
							)
						) {
							module.remove.message();
						}
						if (module.is.allFiltered()) {
							return true;
						}
						if (settings.onShow.call(element) !== false) {
							module.animate.show(function() {
								if (module.can.click()) {
									module.bind.intent();
								}
								if (module.has.menuSearch()) {
									module.focusSearch();
								}
								module.set.visible();
								callback.call(element);
							});
						}
					}
				},

				hide: function(callback) {
					callback = $.isFunction(callback)
						? callback
						: function() {};
					if (module.is.active() && !module.is.animatingOutward()) {
						module.debug("Hiding dropdown");
						if (settings.onHide.call(element) !== false) {
							module.animate.hide(function() {
								module.remove.visible();
								callback.call(element);
							});
						}
					}
				},

				hideOthers: function() {
					module.verbose("Finding other dropdowns to hide");
					$allModules
						.not($module)
						.has(selector.menu + "." + className.visible)
						.dropdownX("hide");
				},

				hideMenu: function() {
					module.verbose("Hiding menu  instantaneously");
					module.remove.active();
					module.remove.visible();
					$menu.transition("hide");
				},

				hideSubMenus: function() {
					var $subMenus = $menu
						.children(selector.item)
						.find(selector.menu);
					module.verbose("Hiding sub menus", $subMenus);
					$subMenus.transition("hide");
				},

				bind: {
					events: function() {
						if (hasTouch) {
							module.bind.touchEvents();
						}
						module.bind.keyboardEvents();
						module.bind.inputEvents();
						module.bind.mouseEvents();
					},
					touchEvents: function() {
						module.debug(
							"Touch device detected binding additional touch events"
						);
						if (module.is.searchSelection()) {
							// do nothing special yet
						} else if (module.is.single()) {
							$module.on(
								"touchstart" + eventNamespace,
								module.event.test.toggle
							);
						}
						$menu.on(
							"touchstart" + eventNamespace,
							selector.item,
							module.event.item.mouseenter
						);
					},
					keyboardEvents: function() {
						module.verbose("Binding keyboard events");
						$module.on(
							"keydown" + eventNamespace,
							module.event.keydown
						);
						if (module.has.search()) {
							$module.on(
								module.get.inputEvent() + eventNamespace,
								selector.search,
								module.event.input
							);
						}
						if (module.is.multiple()) {
							$document.on(
								"keydown" + elementNamespace,
								module.event.document.keydown
							);
						}
					},
					inputEvents: function() {
						module.verbose("Binding input change events");
						$module.on(
							"change" + eventNamespace,
							selector.input,
							module.event.change
						);
					},
					mouseEvents: function() {
						module.verbose("Binding mouse events");
						if (module.is.multiple()) {
							$module
								.on(
									"click" + eventNamespace,
									selector.label,
									module.event.label.click
								)
								.on(
									"click" + eventNamespace,
									selector.remove,
									module.event.remove.click
								);
						}
						if (module.is.searchSelection()) {
							$module
								.on(
									"mousedown" + eventNamespace,
									module.event.mousedown
								)
								.on(
									"mouseup" + eventNamespace,
									module.event.mouseup
								)
								.on(
									"mousedown" + eventNamespace,
									selector.menu,
									module.event.menu.mousedown
								)
								.on(
									"mouseup" + eventNamespace,
									selector.menu,
									module.event.menu.mouseup
								)
								.on(
									"click" + eventNamespace,
									selector.icon,
									module.event.icon.click
								)
								.on(
									"focus" + eventNamespace,
									selector.search,
									module.event.search.focus
								)
								.on(
									"click" + eventNamespace,
									selector.search,
									module.event.search.focus
								)
								.on(
									"blur" + eventNamespace,
									selector.search,
									module.event.search.blur
								)
								.on(
									"click" + eventNamespace,
									selector.text,
									module.event.text.focus
								);
							if (module.is.multiple()) {
								$module.on(
									"click" + eventNamespace,
									module.event.click
								);
							}
						} else {
							if (settings.on == "click") {
								$module.on(
									"click" + eventNamespace,
									module.event.test.toggle
								);
							} else if (settings.on == "hover") {
								$module
									.on(
										"mouseenter" + eventNamespace,
										module.delay.show
									)
									.on(
										"mouseleave" + eventNamespace,
										module.delay.hide
									);
							} else {
								$module.on(
									settings.on + eventNamespace,
									module.toggle
								);
							}
							$module
								.on(
									"click" + eventNamespace,
									selector.icon,
									module.event.icon.click
								)
								.on(
									"mousedown" + eventNamespace,
									module.event.mousedown
								)
								.on(
									"mouseup" + eventNamespace,
									module.event.mouseup
								)
								.on(
									"focus" + eventNamespace,
									module.event.focus
								);
							if (module.has.menuSearch()) {
								$module.on(
									"blur" + eventNamespace,
									selector.search,
									module.event.search.blur
								);
							} else {
								$module.on(
									"blur" + eventNamespace,
									module.event.blur
								);
							}
						}
						$menu
							.on(
								"mouseenter" + eventNamespace,
								selector.item,
								module.event.item.mouseenter
							)
							.on(
								"mouseleave" + eventNamespace,
								selector.item,
								module.event.item.mouseleave
							)
							.on(
								"click" + eventNamespace,
								selector.item,
								module.event.item.click
							);
					},
					intent: function() {
						module.verbose("Binding hide intent event to document");
						if (hasTouch) {
							$document
								.on(
									"touchstart" + elementNamespace,
									module.event.test.touch
								)
								.on(
									"touchmove" + elementNamespace,
									module.event.test.touch
								);
						}
						$document.on(
							"click" + elementNamespace,
							module.event.test.hide
						);
					}
				},

				unbind: {
					intent: function() {
						module.verbose(
							"Removing hide intent event from document"
						);
						if (hasTouch) {
							$document
								.off("touchstart" + elementNamespace)
								.off("touchmove" + elementNamespace);
						}
						$document.off("click" + elementNamespace);
					}
				},

				filter: function(query) {
					var searchTerm =
							query !== undefined ? query : module.get.query(),
						afterFiltered = function() {
							if (module.is.multiple()) {
								module.filterActive();
							}
							if (
								query ||
								(!query && module.get.activeItem().length == 0)
							) {
								module.select.firstUnfiltered();
							}
							if (module.has.allResultsFiltered()) {
								if (
									settings.onNoResults.call(
										element,
										searchTerm
									)
								) {
									if (settings.allowAdditions) {
										if (settings.hideAdditions) {
											module.verbose(
												"User addition with no menu, setting empty style"
											);
											module.set.empty();
											module.hideMenu();
										}
									} else {
										module.verbose(
											"All items filtered, showing message",
											searchTerm
										);
										module.add.message(message.noResults);
									}
								} else {
									module.verbose(
										"All items filtered, hiding dropdown",
										searchTerm
									);
									module.hideMenu();
								}
							} else {
								module.remove.empty();
								module.remove.message();
							}
							if (settings.allowAdditions) {
								module.add.userSuggestion(query);
							}
							if (
								module.is.searchSelection() &&
								module.can.show() &&
								module.is.focusedOnSearch()
							) {
								module.show();
							}
						};
					if (settings.useLabels && module.has.maxSelections()) {
						return;
					}
					if (settings.apiSettings) {
						if (module.can.useAPI()) {
							module.queryRemote(searchTerm, function() {
								if (settings.filterRemoteData) {
									module.filterItems(searchTerm);
								}
								afterFiltered();
							});
						} else {
							module.error(error.noAPI);
						}
					} else {
						module.filterItems(searchTerm);
						afterFiltered();
					}
				},

				queryRemote: function(query, callback) {
					var apiSettings = {
						errorDuration: false,
						cache: "local",
						throttle: settings.throttle,
						urlData: {
							query: query
						},
						onError: function() {
							module.add.message(message.serverError);
							callback();
						},
						onFailure: function() {
							module.add.message(message.serverError);
							callback();
						},
						onSuccess: function(response) {
							var values = response[fields.remoteValues],
								hasRemoteValues =
									$.isArray(values) && values.length > 0;
							if (hasRemoteValues) {
								module.remove.message();
								module.setup.menu({
									values: response[fields.remoteValues]
								});
							} else {
								module.add.message(message.noResults);
							}
							callback();
						}
					};
					if (!$module.api("get request")) {
						module.setup.api();
					}
					apiSettings = $.extend(
						true,
						{},
						apiSettings,
						settings.apiSettings
					);
					$module.api("setting", apiSettings).api("query");
				},

				filterItems: function(query) {
					var searchTerm =
							query !== undefined ? query : module.get.query(),
						results = null,
						escapedTerm = module.escape.string(searchTerm),
						beginsWithRegExp = new RegExp("^" + escapedTerm, "igm");
					// avoid loop if we're matching nothing
					if (module.has.query()) {
						results = [];

						module.verbose(
							"Searching for matching values",
							searchTerm
						);
						$item.each(function() {
							var $choice = $(this),
								text,
								value;
							if (
								settings.match == "both" ||
								settings.match == "text"
							) {
								text = String(
									module.get.choiceText($choice, false)
								);
								if (text.search(beginsWithRegExp) !== -1) {
									results.push(this);
									return true;
								} else if (
									settings.fullTextSearch === "exact" &&
									module.exactSearch(searchTerm, text)
								) {
									results.push(this);
									return true;
								} else if (
									settings.fullTextSearch === true &&
									module.fuzzySearch(searchTerm, text)
								) {
									results.push(this);
									return true;
								}
							}
							if (
								settings.match == "both" ||
								settings.match == "value"
							) {
								value = String(
									module.get.choiceValue($choice, text)
								);
								if (value.search(beginsWithRegExp) !== -1) {
									results.push(this);
									return true;
								} else if (
									settings.fullTextSearch === "exact" &&
									module.exactSearch(searchTerm, value)
								) {
									results.push(this);
									return true;
								} else if (
									settings.fullTextSearch === true &&
									module.fuzzySearch(searchTerm, value)
								) {
									results.push(this);
									return true;
								}
							}
						});
					}
					module.debug("Showing only matched items", searchTerm);
					module.remove.filteredItem();
					if (results) {
						$item.not(results).addClass(className.filtered);
					}
				},

				fuzzySearch: function(query, term) {
					var termLength = term.length,
						queryLength = query.length;
					query = query.toLowerCase();
					term = term.toLowerCase();
					if (queryLength > termLength) {
						return false;
					}
					if (queryLength === termLength) {
						return query === term;
					}
					search: for (
						var characterIndex = 0, nextCharacterIndex = 0;
						characterIndex < queryLength;
						characterIndex++
					) {
						var queryCharacter = query.charCodeAt(characterIndex);
						while (nextCharacterIndex < termLength) {
							if (
								term.charCodeAt(nextCharacterIndex++) ===
								queryCharacter
							) {
								continue search;
							}
						}
						return false;
					}
					return true;
				},
				exactSearch: function(query, term) {
					query = query.toLowerCase();
					term = term.toLowerCase();
					if (term.indexOf(query) > -1) {
						return true;
					}
					return false;
				},
				filterActive: function() {
					if (settings.useLabels) {
						$item
							.filter("." + className.active)
							.addClass(className.filtered);
					}
				},

				focusSearch: function(skipHandler) {
					if (module.has.search() && !module.is.focusedOnSearch()) {
						if (skipHandler) {
							$module.off(
								"focus" + eventNamespace,
								selector.search
							);
							$search.focus();
							$module.on(
								"focus" + eventNamespace,
								selector.search,
								module.event.search.focus
							);
						} else {
							$search.focus();
						}
					}
				},

				forceSelection: function() {
					var $currentlySelected = $item
							.not(className.filtered)
							.filter("." + className.selected)
							.eq(0),
						$activeItem = $item
							.not(className.filtered)
							.filter("." + className.active)
							.eq(0),
						$selectedItem =
							$currentlySelected.length > 0
								? $currentlySelected
								: $activeItem,
						hasSelected = $selectedItem.length > 0;
					if (hasSelected && !module.is.multiple()) {
						module.debug(
							"Forcing partial selection to selected item",
							$selectedItem
						);
						module.event.item.click.call($selectedItem, {}, true);
						return;
					} else {
						if (settings.allowAdditions) {
							module.set.selected(module.get.query());
							module.remove.searchTerm();
						} else {
							module.remove.searchTerm();
						}
					}
				},

				change: {
					values: function(values) {
						if (!settings.allowAdditions) {
							module.clear();
						}
						module.debug(
							"Creating dropdown with specified values",
							values
						);
						module.setup.menu({ values: values });
						$.each(values, function(index, item) {
							if (item.selected == true) {
								module.debug(
									"Setting initial selection to",
									item.value
								);
								module.set.selected(item.value);
								return true;
							}
						});
					}
				},

				event: {
					change: function() {
						if (!internalChange) {
							module.debug("Input changed, updating selection");
							module.set.selected();
						}
					},
					focus: function() {
						if (
							settings.showOnFocus &&
							!activated &&
							module.is.hidden() &&
							!pageLostFocus
						) {
							module.show();
						}
					},
					blur: function(event) {
						pageLostFocus = document.activeElement === this;
						if (!activated && !pageLostFocus) {
							module.remove.activeLabel();
							module.hide();
						}
					},
					mousedown: function() {
						if (module.is.searchSelection()) {
							// prevent menu hiding on immediate re-focus
							willRefocus = true;
						} else {
							// prevents focus callback from occurring on mousedown
							activated = true;
						}
					},
					mouseup: function() {
						if (module.is.searchSelection()) {
							// prevent menu hiding on immediate re-focus
							willRefocus = false;
						} else {
							activated = false;
						}
					},
					click: function(event) {
						var $target = $(event.target);
						// focus search
						if ($target.is($module)) {
							if (!module.is.focusedOnSearch()) {
								module.focusSearch();
							} else {
								module.show();
							}
						}
					},
					search: {
						focus: function() {
							activated = true;
							if (module.is.multiple()) {
								module.remove.activeLabel();
							}
							if (settings.showOnFocus) {
								module.search();
							}
						},
						blur: function(event) {
							pageLostFocus = document.activeElement === this;
							if (module.is.searchSelection() && !willRefocus) {
								if (!itemActivated && !pageLostFocus) {
									if (settings.forceSelection) {
										module.forceSelection();
									}
									module.hide();
								}
							}
							willRefocus = false;
						}
					},
					icon: {
						click: function(event) {
							if ($icon.hasClass(className.clear)) {
								module.clear();
							} else if (module.can.click()) {
								module.toggle();
							}
						}
					},
					text: {
						focus: function(event) {
							activated = true;
							module.focusSearch();
						}
					},
					input: function(event) {
						if (
							module.is.multiple() ||
							module.is.searchSelection()
						) {
							module.set.filtered();
						}
						clearTimeout(module.timer);
						module.timer = setTimeout(
							module.search,
							settings.delay.search
						);
					},
					label: {
						click: function(event) {
							var $label = $(this),
								$labels = $module.find(selector.label),
								$activeLabels = $labels.filter(
									"." + className.active
								),
								$nextActive = $label.nextAll(
									"." + className.active
								),
								$prevActive = $label.prevAll(
									"." + className.active
								),
								$range =
									$nextActive.length > 0
										? $label
												.nextUntil($nextActive)
												.add($activeLabels)
												.add($label)
										: $label
												.prevUntil($prevActive)
												.add($activeLabels)
												.add($label);
							if (event.shiftKey) {
								$activeLabels.removeClass(className.active);
								$range.addClass(className.active);
							} else if (event.ctrlKey) {
								$label.toggleClass(className.active);
							} else {
								$activeLabels.removeClass(className.active);
								$label.addClass(className.active);
							}
							settings.onLabelSelect.apply(
								this,
								$labels.filter("." + className.active)
							);
						}
					},
					remove: {
						click: function() {
							var $label = $(this).parent();
							if ($label.hasClass(className.active)) {
								// remove all selected labels
								module.remove.activeLabels();
							} else {
								// remove this label only
								module.remove.activeLabels($label);
							}
						}
					},
					test: {
						toggle: function(event) {
							var toggleBehavior = module.is.multiple()
								? module.show
								: module.toggle;
							if (
								module.is.bubbledLabelClick(event) ||
								module.is.bubbledIconClick(event)
							) {
								return;
							}
							if (
								module.determine.eventOnElement(
									event,
									toggleBehavior
								)
							) {
								event.preventDefault();
							}
						},
						touch: function(event) {
							module.determine.eventOnElement(event, function() {
								if (event.type == "touchstart") {
									module.timer = setTimeout(function() {
										module.hide();
									}, settings.delay.touch);
								} else if (event.type == "touchmove") {
									clearTimeout(module.timer);
								}
							});
							event.stopPropagation();
						},
						hide: function(event) {
							module.determine.eventInModule(event, module.hide);
						}
					},
					select: {
						mutation: function(mutations) {
							module.debug("<select> modified, recreating menu");
							var isSelectMutation = false;
							$.each(mutations, function(index, mutation) {
								if (
									$(mutation.target).is("select") ||
									$(mutation.addedNodes).is("select")
								) {
									isSelectMutation = true;
									return true;
								}
							});
							if (isSelectMutation) {
								module.disconnect.selectObserver();
								module.refresh();
								module.setup.select();
								module.set.selected();
								module.observe.select();
							}
						}
					},
					menu: {
						mutation: function(mutations) {
							var mutation = mutations[0],
								$addedNode = mutation.addedNodes
									? $(mutation.addedNodes[0])
									: $(false),
								$removedNode = mutation.removedNodes
									? $(mutation.removedNodes[0])
									: $(false),
								$changedNodes = $addedNode.add($removedNode),
								isUserAddition =
									$changedNodes.is(selector.addition) ||
									$changedNodes.closest(selector.addition)
										.length > 0,
								isMessage =
									$changedNodes.is(selector.message) ||
									$changedNodes.closest(selector.message)
										.length > 0;
							if (isUserAddition || isMessage) {
								module.debug("Updating item selector cache");
								module.refreshItems();
							} else {
								module.debug(
									"Menu modified, updating selector cache"
								);
								module.refresh();
							}
						},
						mousedown: function() {
							itemActivated = true;
						},
						mouseup: function() {
							itemActivated = false;
						}
					},
					item: {
						mouseenter: function(event) {
							var $target = $(event.target),
								$item = $(this),
								$subMenu = $item.children(selector.menu),
								$otherMenus = $item
									.siblings(selector.item)
									.children(selector.menu),
								hasSubMenu = $subMenu.length > 0,
								isBubbledEvent =
									$subMenu.find($target).length > 0;
							if (!isBubbledEvent && hasSubMenu) {
								clearTimeout(module.itemTimer);
								module.itemTimer = setTimeout(function() {
									module.verbose(
										"Showing sub-menu",
										$subMenu
									);
									$.each($otherMenus, function() {
										module.animate.hide(false, $(this));
									});
									module.animate.show(false, $subMenu);
								}, settings.delay.show);
								event.preventDefault();
							}
						},
						mouseleave: function(event) {
							var $subMenu = $(this).children(selector.menu);
							if ($subMenu.length > 0) {
								clearTimeout(module.itemTimer);
								module.itemTimer = setTimeout(function() {
									module.verbose("Hiding sub-menu", $subMenu);
									module.animate.hide(false, $subMenu);
								}, settings.delay.hide);
							}
						},
						click: function(event, skipRefocus) {
							var $choice = $(this),
								$target = event ? $(event.target) : $(""),
								$subMenu = $choice.find(selector.menu),
								text = module.get.choiceText($choice),
								value = module.get.choiceValue($choice, text),
								hasSubMenu = $subMenu.length > 0,
								isBubbledEvent =
									$subMenu.find($target).length > 0;
							// prevents IE11 bug where menu receives focus even though `tabindex=-1`
							if (module.has.menuSearch()) {
								$(document.activeElement).blur();
							}
							if (
								!isBubbledEvent &&
								(!hasSubMenu || settings.allowCategorySelection)
							) {
								if (module.is.searchSelection()) {
									if (settings.allowAdditions) {
										module.remove.userAddition();
									}
									module.remove.searchTerm();
									if (
										!module.is.focusedOnSearch() &&
										!(skipRefocus == true)
									) {
										module.focusSearch(true);
									}
								}
								if (!settings.useLabels) {
									module.remove.filteredItem();
									module.set.scrollPosition($choice);
								}
								module.determine.selectAction.call(
									this,
									text,
									value
								);
							}
						}
					},

					document: {
						// label selection should occur even when element has no focus
						keydown: function(event) {
							var pressedKey = event.which,
								isShortcutKey = module.is.inObject(
									pressedKey,
									keys
								);
							if (isShortcutKey) {
								var $label = $module.find(selector.label),
									$activeLabel = $label.filter(
										"." + className.active
									),
									activeValue = $activeLabel.data(
										metadata.value
									),
									labelIndex = $label.index($activeLabel),
									labelCount = $label.length,
									hasActiveLabel = $activeLabel.length > 0,
									hasMultipleActive = $activeLabel.length > 1,
									isFirstLabel = labelIndex === 0,
									isLastLabel = labelIndex + 1 == labelCount,
									isSearch = module.is.searchSelection(),
									isFocusedOnSearch = module.is.focusedOnSearch(),
									isFocused = module.is.focused(),
									caretAtStart =
										isFocusedOnSearch &&
										module.get.caretPosition() === 0,
									$nextLabel;
								if (
									isSearch &&
									!hasActiveLabel &&
									!isFocusedOnSearch
								) {
									return;
								}

								if (pressedKey == keys.leftArrow) {
									// activate previous label
									if (
										(isFocused || caretAtStart) &&
										!hasActiveLabel
									) {
										module.verbose(
											"Selecting previous label"
										);
										$label
											.last()
											.addClass(className.active);
									} else if (hasActiveLabel) {
										if (!event.shiftKey) {
											module.verbose(
												"Selecting previous label"
											);
											$label.removeClass(
												className.active
											);
										} else {
											module.verbose(
												"Adding previous label to selection"
											);
										}
										if (
											isFirstLabel &&
											!hasMultipleActive
										) {
											$activeLabel.addClass(
												className.active
											);
										} else {
											$activeLabel
												.prev(selector.siblingLabel)
												.addClass(className.active)
												.end();
										}
										event.preventDefault();
									}
								} else if (pressedKey == keys.rightArrow) {
									// activate first label
									if (isFocused && !hasActiveLabel) {
										$label
											.first()
											.addClass(className.active);
									}
									// activate next label
									if (hasActiveLabel) {
										if (!event.shiftKey) {
											module.verbose(
												"Selecting next label"
											);
											$label.removeClass(
												className.active
											);
										} else {
											module.verbose(
												"Adding next label to selection"
											);
										}
										if (isLastLabel) {
											if (isSearch) {
												if (!isFocusedOnSearch) {
													module.focusSearch();
												} else {
													$label.removeClass(
														className.active
													);
												}
											} else if (hasMultipleActive) {
												$activeLabel
													.next(selector.siblingLabel)
													.addClass(className.active);
											} else {
												$activeLabel.addClass(
													className.active
												);
											}
										} else {
											$activeLabel
												.next(selector.siblingLabel)
												.addClass(className.active);
										}
										event.preventDefault();
									}
								} else if (
									pressedKey == keys.deleteKey ||
									pressedKey == keys.backspace
								) {
									if (hasActiveLabel) {
										module.verbose(
											"Removing active labels"
										);
										if (isLastLabel) {
											if (
												isSearch &&
												!isFocusedOnSearch
											) {
												module.focusSearch();
											}
										}
										$activeLabel
											.last()
											.next(selector.siblingLabel)
											.addClass(className.active);
										module.remove.activeLabels(
											$activeLabel
										);
										event.preventDefault();
									} else if (
										caretAtStart &&
										!hasActiveLabel &&
										pressedKey == keys.backspace
									) {
										module.verbose(
											"Removing last label on input backspace"
										);
										$activeLabel = $label
											.last()
											.addClass(className.active);
										module.remove.activeLabels(
											$activeLabel
										);
									}
								} else {
									$activeLabel.removeClass(className.active);
								}
							}
						}
					},

					keydown: function(event) {
						var pressedKey = event.which,
							isShortcutKey = module.is.inObject(
								pressedKey,
								keys
							);
						if (isShortcutKey) {
							var $currentlySelected = $item
									.not(selector.unselectable)
									.filter("." + className.selected)
									.eq(0),
								$activeItem = $menu
									.children("." + className.active)
									.eq(0),
								$selectedItem =
									$currentlySelected.length > 0
										? $currentlySelected
										: $activeItem,
								$visibleItems =
									$selectedItem.length > 0
										? $selectedItem
												.siblings(
													":not(." +
														className.filtered +
														")"
												)
												.addBack()
										: $menu.children(
												":not(." +
													className.filtered +
													")"
										  ),
								$subMenu = $selectedItem.children(
									selector.menu
								),
								$parentMenu = $selectedItem.closest(
									selector.menu
								),
								inVisibleMenu =
									$parentMenu.hasClass(className.visible) ||
									$parentMenu.hasClass(className.animating) ||
									$parentMenu.parent(selector.menu).length >
										0,
								hasSubMenu = $subMenu.length > 0,
								hasSelectedItem = $selectedItem.length > 0,
								selectedIsSelectable =
									$selectedItem.not(selector.unselectable)
										.length > 0,
								delimiterPressed =
									pressedKey == keys.delimiter &&
									settings.allowAdditions &&
									module.is.multiple(),
								isAdditionWithoutMenu =
									settings.allowAdditions &&
									settings.hideAdditions &&
									(pressedKey == keys.enter ||
										delimiterPressed) &&
									selectedIsSelectable,
								$nextItem,
								isSubMenuItem,
								newIndex;
							// allow selection with menu closed
							if (isAdditionWithoutMenu) {
								module.verbose(
									"Selecting item from keyboard shortcut",
									$selectedItem
								);
								module.event.item.click.call(
									$selectedItem,
									event
								);
								if (module.is.searchSelection()) {
									module.remove.searchTerm();
								}
							}

							// visible menu keyboard shortcuts
							if (module.is.visible()) {
								// enter (select or open sub-menu)
								if (
									pressedKey == keys.enter ||
									delimiterPressed
								) {
									if (
										pressedKey == keys.enter &&
										hasSelectedItem &&
										hasSubMenu &&
										!settings.allowCategorySelection
									) {
										module.verbose(
											"Pressed enter on unselectable category, opening sub menu"
										);
										pressedKey = keys.rightArrow;
									} else if (selectedIsSelectable) {
										module.verbose(
											"Selecting item from keyboard shortcut",
											$selectedItem
										);
										module.event.item.click.call(
											$selectedItem,
											event
										);
										if (module.is.searchSelection()) {
											module.remove.searchTerm();
										}
									}
									event.preventDefault();
								}

								// sub-menu actions
								if (hasSelectedItem) {
									if (pressedKey == keys.leftArrow) {
										isSubMenuItem =
											$parentMenu[0] !== $menu[0];

										if (isSubMenuItem) {
											module.verbose(
												"Left key pressed, closing sub-menu"
											);
											module.animate.hide(
												false,
												$parentMenu
											);
											$selectedItem.removeClass(
												className.selected
											);
											$parentMenu
												.closest(selector.item)
												.addClass(className.selected);
											event.preventDefault();
										}
									}

									// right arrow (show sub-menu)
									if (pressedKey == keys.rightArrow) {
										if (hasSubMenu) {
											module.verbose(
												"Right key pressed, opening sub-menu"
											);
											module.animate.show(
												false,
												$subMenu
											);
											$selectedItem.removeClass(
												className.selected
											);
											$subMenu
												.find(selector.item)
												.eq(0)
												.addClass(className.selected);
											event.preventDefault();
										}
									}
								}

								// up arrow (traverse menu up)
								if (pressedKey == keys.upArrow) {
									$nextItem =
										hasSelectedItem && inVisibleMenu
											? $selectedItem
													.prevAll(
														selector.item +
															":not(" +
															selector.unselectable +
															")"
													)
													.eq(0)
											: $item.eq(0);
									if ($visibleItems.index($nextItem) < 0) {
										module.verbose(
											"Up key pressed but reached top of current menu"
										);
										event.preventDefault();
										return;
									} else {
										module.verbose(
											"Up key pressed, changing active item"
										);
										$selectedItem.removeClass(
											className.selected
										);
										$nextItem.addClass(className.selected);
										module.set.scrollPosition($nextItem);
										if (
											settings.selectOnKeydown &&
											module.is.single()
										) {
											module.set.selectedItem($nextItem);
										}
									}
									event.preventDefault();
								}

								// down arrow (traverse menu down)
								if (pressedKey == keys.downArrow) {
									$nextItem =
										hasSelectedItem && inVisibleMenu
											? ($nextItem = $selectedItem
													.nextAll(
														selector.item +
															":not(" +
															selector.unselectable +
															")"
													)
													.eq(0))
											: $item.eq(0);
									if ($nextItem.length === 0) {
										module.verbose(
											"Down key pressed but reached bottom of current menu"
										);
										event.preventDefault();
										return;
									} else {
										module.verbose(
											"Down key pressed, changing active item"
										);
										$item.removeClass(className.selected);
										$nextItem.addClass(className.selected);
										module.set.scrollPosition($nextItem);
										if (
											settings.selectOnKeydown &&
											module.is.single()
										) {
											module.set.selectedItem($nextItem);
										}
									}
									event.preventDefault();
								}

								// page down (show next page)
								if (pressedKey == keys.pageUp) {
									module.scrollPage("up");
									event.preventDefault();
								}
								if (pressedKey == keys.pageDown) {
									module.scrollPage("down");
									event.preventDefault();
								}

								// escape (close menu)
								if (pressedKey == keys.escape) {
									module.verbose(
										"Escape key pressed, closing dropdown"
									);
									module.hide();
								}
							} else {
								// delimiter key
								if (delimiterPressed) {
									event.preventDefault();
								}
								// down arrow (open menu)
								if (
									pressedKey == keys.downArrow &&
									!module.is.visible()
								) {
									module.verbose(
										"Down key pressed, showing dropdown"
									);
									module.show();
									event.preventDefault();
								}
							}
						} else {
							if (!module.has.search()) {
								module.set.selectedLetter(
									String.fromCharCode(pressedKey)
								);
							}
						}
					}
				},

				trigger: {
					change: function() {
						var events = document.createEvent("HTMLEvents"),
							inputElement = $input[0];
						if (inputElement) {
							module.verbose("Triggering native change event");
							events.initEvent("change", true, false);
							inputElement.dispatchEvent(events);
						}
					}
				},

				determine: {
					selectAction: function(text, value) {
						module.verbose("Determining action", settings.action);
						if ($.isFunction(module.action[settings.action])) {
							module.verbose(
								"Triggering preset action",
								settings.action,
								text,
								value
							);
							module.action[settings.action].call(
								element,
								text,
								value,
								this
							);
						} else if ($.isFunction(settings.action)) {
							module.verbose(
								"Triggering user action",
								settings.action,
								text,
								value
							);
							settings.action.call(element, text, value, this);
						} else {
							module.error(error.action, settings.action);
						}
					},
					eventInModule: function(event, callback) {
						var $target = $(event.target),
							inDocument =
								$target.closest(document.documentElement)
									.length > 0,
							inModule = $target.closest($module).length > 0;
						callback = $.isFunction(callback)
							? callback
							: function() {};
						if (inDocument && !inModule) {
							module.verbose("Triggering event", callback);
							callback();
							return true;
						} else {
							module.verbose(
								"Event occurred in dropdown, canceling callback"
							);
							return false;
						}
					},
					eventOnElement: function(event, callback) {
						var $target = $(event.target),
							$label = $target.closest(selector.siblingLabel),
							inVisibleDOM = document.body.contains(event.target),
							notOnLabel = $module.find($label).length === 0,
							notInMenu = $target.closest($menu).length === 0;
						callback = $.isFunction(callback)
							? callback
							: function() {};
						if (inVisibleDOM && notOnLabel && notInMenu) {
							module.verbose("Triggering event", callback);
							callback();
							return true;
						} else {
							module.verbose(
								"Event occurred in dropdown menu, canceling callback"
							);
							return false;
						}
					}
				},

				action: {
					nothing: function() {},

					activate: function(text, value, element) {
						value = value !== undefined ? value : text;
						if (module.can.activate($(element))) {
							module.set.selected(value, $(element));
							if (
								module.is.multiple() &&
								!module.is.allFiltered()
							) {
								return;
							} else {
								module.hideAndClear();
							}
						}
					},

					select: function(text, value, element) {
						value = value !== undefined ? value : text;
						if (module.can.activate($(element))) {
							module.set.value(value, text, $(element));
							if (
								module.is.multiple() &&
								!module.is.allFiltered()
							) {
								return;
							} else {
								module.hideAndClear();
							}
						}
					},

					combo: function(text, value, element) {
						value = value !== undefined ? value : text;
						module.set.selected(value, $(element));
						module.hideAndClear();
					},

					hide: function(text, value, element) {
						module.set.value(value, text, $(element));
						module.hideAndClear();
					}
				},

				get: {
					id: function() {
						return id;
					},
					defaultText: function() {
						return $module.data(metadata.defaultText);
					},
					defaultValue: function() {
						return $module.data(metadata.defaultValue);
					},
					placeholderText: function() {
						if (
							settings.placeholder != "auto" &&
							typeof settings.placeholder == "string"
						) {
							return settings.placeholder;
						}
						return $module.data(metadata.placeholderText) || "";
					},
					text: function() {
						return $text.text();
					},
					query: function() {
						return $.trim($search.val());
					},
					searchWidth: function(value) {
						value = value !== undefined ? value : $search.val();
						$sizer.text(value);
						// prevent rounding issues
						return Math.ceil($sizer.width() + 1);
					},
					selectionCount: function() {
						var values = module.get.values(),
							count;
						count = module.is.multiple()
							? $.isArray(values)
								? values.length
								: 0
							: module.get.value() !== ""
							? 1
							: 0;
						return count;
					},
					transition: function($subMenu) {
						return settings.transition == "auto"
							? module.is.upward($subMenu)
								? "slide up"
								: "slide down"
							: settings.transition;
					},
					userValues: function() {
						var values = module.get.values();
						if (!values) {
							return false;
						}
						values = $.isArray(values) ? values : [values];
						return $.grep(values, function(value) {
							return module.get.item(value) === false;
						});
					},
					uniqueArray: function(array) {
						return $.grep(array, function(value, index) {
							return $.inArray(value, array) === index;
						});
					},
					caretPosition: function() {
						var input = $search.get(0),
							range,
							rangeLength;
						if ("selectionStart" in input) {
							return input.selectionStart;
						} else if (document.selection) {
							input.focus();
							range = document.selection.createRange();
							rangeLength = range.text.length;
							range.moveStart("character", -input.value.length);
							return range.text.length - rangeLength;
						}
					},
					value: function() {
						var value =
								$input.length > 0
									? $input.val()
									: $module.data(metadata.value),
							isEmptyMultiselect =
								$.isArray(value) &&
								value.length === 1 &&
								value[0] === "";
						// prevents placeholder element from being selected when multiple
						return value === undefined || isEmptyMultiselect
							? ""
							: value;
					},
					values: function() {
						var value = module.get.value();
						if (value === "") {
							return "";
						}
						return !module.has.selectInput() && module.is.multiple()
							? typeof value == "string" // delimited string
								? value.split(settings.delimiter)
								: ""
							: value;
					},
					remoteValues: function() {
						var values = module.get.values(),
							remoteValues = false;
						if (values) {
							if (typeof values == "string") {
								values = [values];
							}
							$.each(values, function(index, value) {
								var name = module.read.remoteData(value);
								module.verbose(
									"Restoring value from session data",
									name,
									value
								);
								if (name) {
									if (!remoteValues) {
										remoteValues = {};
									}
									remoteValues[value] = name;
								}
							});
						}
						return remoteValues;
					},
					choiceText: function($choice, preserveHTML) {
						preserveHTML =
							preserveHTML !== undefined
								? preserveHTML
								: settings.preserveHTML;
						if ($choice) {
							if ($choice.find(selector.menu).length > 0) {
								module.verbose(
									"Retrieving text of element with sub-menu"
								);
								$choice = $choice.clone();
								$choice.find(selector.menu).remove();
								$choice.find(selector.menuIcon).remove();
							}
							return $choice.data(metadata.text) !== undefined
								? $choice.data(metadata.text)
								: preserveHTML
								? $.trim($choice.html())
								: $.trim($choice.text());
						}
					},
					choiceValue: function($choice, choiceText) {
						choiceText =
							choiceText || module.get.choiceText($choice);
						if (!$choice) {
							return false;
						}
						return $choice.data(metadata.value) !== undefined
							? String($choice.data(metadata.value))
							: typeof choiceText === "string"
							? $.trim(choiceText.toLowerCase())
							: String(choiceText);
					},
					inputEvent: function() {
						var input = $search[0];
						if (input) {
							return input.oninput !== undefined
								? "input"
								: input.onpropertychange !== undefined
								? "propertychange"
								: "keyup";
						}
						return false;
					},
					selectValues: function() {
						var select = {};
						select.values = [];
						$module.find("option").each(function() {
							var $option = $(this),
								name = $option.html(),
								disabled = $option.attr("disabled"),
								value =
									$option.attr("value") !== undefined
										? $option.attr("value")
										: name;
							if (
								settings.placeholder === "auto" &&
								value === ""
							) {
								select.placeholder = name;
							} else {
								select.values.push({
									name: name,
									value: value,
									disabled: disabled
								});
							}
						});
						if (
							settings.placeholder &&
							settings.placeholder !== "auto"
						) {
							module.debug(
								"Setting placeholder value to",
								settings.placeholder
							);
							select.placeholder = settings.placeholder;
						}
						if (settings.sortSelect) {
							select.values.sort(function(a, b) {
								return a.name > b.name ? 1 : -1;
							});
							module.debug(
								"Retrieved and sorted values from select",
								select
							);
						} else {
							module.debug(
								"Retrieved values from select",
								select
							);
						}
						return select;
					},
					activeItem: function() {
						return $item.filter("." + className.active);
					},
					selectedItem: function() {
						var $selectedItem = $item
							.not(selector.unselectable)
							.filter("." + className.selected);
						return $selectedItem.length > 0
							? $selectedItem
							: $item.eq(0);
					},
					itemWithAdditions: function(value) {
						var $items = module.get.item(value),
							$userItems = module.create.userChoice(value),
							hasUserItems = $userItems && $userItems.length > 0;
						if (hasUserItems) {
							$items =
								$items.length > 0
									? $items.add($userItems)
									: $userItems;
						}
						return $items;
					},
					item: function(value, strict) {
						var $selectedItem = false,
							shouldSearch,
							isMultiple;
						value =
							value !== undefined
								? value
								: module.get.values() !== undefined
								? module.get.values()
								: module.get.text();
						shouldSearch = isMultiple
							? value.length > 0
							: value !== undefined && value !== null;
						isMultiple = module.is.multiple() && $.isArray(value);
						strict =
							value === "" || value === 0
								? true
								: strict || false;
						if (shouldSearch) {
							$item.each(function() {
								var $choice = $(this),
									optionText = module.get.choiceText($choice),
									optionValue = module.get.choiceValue(
										$choice,
										optionText
									);
								// safe early exit
								if (
									optionValue === null ||
									optionValue === undefined
								) {
									return;
								}
								if (isMultiple) {
									if (
										$.inArray(
											String(optionValue),
											value
										) !== -1 ||
										$.inArray(optionText, value) !== -1
									) {
										$selectedItem = $selectedItem
											? $selectedItem.add($choice)
											: $choice;
									}
								} else if (strict) {
									module.verbose(
										"Ambiguous dropdown value using strict type check",
										$choice,
										value
									);
									if (
										optionValue === value ||
										optionText === value
									) {
										$selectedItem = $choice;
										return true;
									}
								} else {
									if (
										String(optionValue) == String(value) ||
										optionText == value
									) {
										module.verbose(
											"Found select item by value",
											optionValue,
											value
										);
										$selectedItem = $choice;
										return true;
									}
								}
							});
						}
						return $selectedItem;
					}
				},

				check: {
					maxSelections: function(selectionCount) {
						if (settings.maxSelections) {
							selectionCount =
								selectionCount !== undefined
									? selectionCount
									: module.get.selectionCount();
							if (selectionCount >= settings.maxSelections) {
								module.debug("Maximum selection count reached");
								if (settings.useLabels) {
									$item.addClass(className.filtered);
									module.add.message(message.maxSelections);
								}
								return true;
							} else {
								module.verbose(
									"No longer at maximum selection count"
								);
								module.remove.message();
								module.remove.filteredItem();
								if (module.is.searchSelection()) {
									module.filterItems();
								}
								return false;
							}
						}
						return true;
					}
				},

				restore: {
					defaults: function() {
						module.clear();
						module.restore.defaultText();
						module.restore.defaultValue();
					},
					defaultText: function() {
						var defaultText = module.get.defaultText(),
							placeholderText = module.get.placeholderText;
						if (defaultText === placeholderText) {
							module.debug(
								"Restoring default placeholder text",
								defaultText
							);
							module.set.placeholderText(defaultText);
						} else {
							module.debug("Restoring default text", defaultText);
							module.set.text(defaultText);
						}
					},
					placeholderText: function() {
						module.set.placeholderText();
					},
					defaultValue: function() {
						var defaultValue = module.get.defaultValue();
						if (defaultValue !== undefined) {
							module.debug(
								"Restoring default value",
								defaultValue
							);
							if (defaultValue !== "") {
								module.set.value(defaultValue);
								module.set.selected();
							} else {
								module.remove.activeItem();
								module.remove.selectedItem();
							}
						}
					},
					labels: function() {
						if (settings.allowAdditions) {
							if (!settings.useLabels) {
								module.error(error.labels);
								settings.useLabels = true;
							}
							module.debug("Restoring selected values");
							module.create.userLabels();
						}
						module.check.maxSelections();
					},
					selected: function() {
						module.restore.values();
						if (module.is.multiple()) {
							module.debug(
								"Restoring previously selected values and labels"
							);
							module.restore.labels();
						} else {
							module.debug(
								"Restoring previously selected values"
							);
						}
					},
					values: function() {
						// prevents callbacks from occurring on initial load
						module.set.initialLoad();
						if (
							settings.apiSettings &&
							settings.saveRemoteData &&
							module.get.remoteValues()
						) {
							module.restore.remoteValues();
						} else {
							module.set.selected();
						}
						module.remove.initialLoad();
					},
					remoteValues: function() {
						var values = module.get.remoteValues();
						module.debug(
							"Recreating selected from session data",
							values
						);
						if (values) {
							if (module.is.single()) {
								$.each(values, function(value, name) {
									module.set.text(name);
								});
							} else {
								$.each(values, function(value, name) {
									module.add.label(value, name);
								});
							}
						}
					}
				},

				read: {
					remoteData: function(value) {
						var name;
						if (window.Storage === undefined) {
							module.error(error.noStorage);
							return;
						}
						name = sessionStorage.getItem(value);
						return name !== undefined ? name : false;
					}
				},

				save: {
					defaults: function() {
						module.save.defaultText();
						module.save.placeholderText();
						module.save.defaultValue();
					},
					defaultValue: function() {
						var value = module.get.value();
						module.verbose("Saving default value as", value);
						$module.data(metadata.defaultValue, value);
					},
					defaultText: function() {
						var text = module.get.text();
						module.verbose("Saving default text as", text);
						$module.data(metadata.defaultText, text);
					},
					placeholderText: function() {
						var text;
						if (
							settings.placeholder !== false &&
							$text.hasClass(className.placeholder)
						) {
							text = module.get.text();
							module.verbose("Saving placeholder text as", text);
							$module.data(metadata.placeholderText, text);
						}
					},
					remoteData: function(name, value) {
						if (window.Storage === undefined) {
							module.error(error.noStorage);
							return;
						}
						module.verbose(
							"Saving remote data to session storage",
							value,
							name
						);
						sessionStorage.setItem(value, name);
					}
				},

				clear: function() {
					if (module.is.multiple() && settings.useLabels) {
						module.remove.labels();
					} else {
						module.remove.activeItem();
						module.remove.selectedItem();
					}
					module.set.placeholderText();
					module.clearValue();
				},

				clearValue: function() {
					module.set.value("");
				},

				scrollPage: function(direction, $selectedItem) {
					var $currentItem =
							$selectedItem || module.get.selectedItem(),
						$menu = $currentItem.closest(selector.menu),
						menuHeight = $menu.outerHeight(),
						currentScroll = $menu.scrollTop(),
						itemHeight = $item.eq(0).outerHeight(),
						itemsPerPage = Math.floor(menuHeight / itemHeight),
						maxScroll = $menu.prop("scrollHeight"),
						newScroll =
							direction == "up"
								? currentScroll - itemHeight * itemsPerPage
								: currentScroll + itemHeight * itemsPerPage,
						$selectableItem = $item.not(selector.unselectable),
						isWithinRange,
						$nextSelectedItem,
						elementIndex;
					elementIndex =
						direction == "up"
							? $selectableItem.index($currentItem) - itemsPerPage
							: $selectableItem.index($currentItem) +
							  itemsPerPage;
					isWithinRange =
						direction == "up"
							? elementIndex >= 0
							: elementIndex < $selectableItem.length;
					$nextSelectedItem = isWithinRange
						? $selectableItem.eq(elementIndex)
						: direction == "up"
						? $selectableItem.first()
						: $selectableItem.last();
					if ($nextSelectedItem.length > 0) {
						module.debug(
							"Scrolling page",
							direction,
							$nextSelectedItem
						);
						$currentItem.removeClass(className.selected);
						$nextSelectedItem.addClass(className.selected);
						if (settings.selectOnKeydown && module.is.single()) {
							module.set.selectedItem($nextSelectedItem);
						}
						$menu.scrollTop(newScroll);
					}
				},

				set: {
					filtered: function() {
						var isMultiple = module.is.multiple(),
							isSearch = module.is.searchSelection(),
							isSearchMultiple = isMultiple && isSearch,
							searchValue = isSearch ? module.get.query() : "",
							hasSearchValue =
								typeof searchValue === "string" &&
								searchValue.length > 0,
							searchWidth = module.get.searchWidth(),
							valueIsSet = searchValue !== "";
						if (isMultiple && hasSearchValue) {
							module.verbose(
								"Adjusting input width",
								searchWidth,
								settings.glyphWidth
							);
							$search.css("width", searchWidth);
						}
						if (
							hasSearchValue ||
							(isSearchMultiple && valueIsSet)
						) {
							module.verbose("Hiding placeholder text");
							$text.addClass(className.filtered);
						} else if (
							!isMultiple ||
							(isSearchMultiple && !valueIsSet)
						) {
							module.verbose("Showing placeholder text");
							$text.removeClass(className.filtered);
						}
					},
					empty: function() {
						$module.addClass(className.empty);
					},
					loading: function() {
						$module.addClass(className.loading);
					},
					placeholderText: function(text) {
						text = text || module.get.placeholderText();
						module.debug("Setting placeholder text", text);
						module.set.text(text);
						$text.addClass(className.placeholder);
					},
					tabbable: function() {
						if (module.is.searchSelection()) {
							module.debug(
								"Added tabindex to searchable dropdown"
							);
							$search.val("").attr("tabindex", 0);
							$menu.attr("tabindex", -1);
						} else {
							module.debug("Added tabindex to dropdown");
							if ($module.attr("tabindex") === undefined) {
								$module.attr("tabindex", 0);
								$menu.attr("tabindex", -1);
							}
						}
					},
					initialLoad: function() {
						module.verbose("Setting initial load");
						initialLoad = true;
					},
					activeItem: function($item) {
						if (
							settings.allowAdditions &&
							$item.filter(selector.addition).length > 0
						) {
							$item.addClass(className.filtered);
						} else {
							$item.addClass(className.active);
						}
					},
					partialSearch: function(text) {
						var length = module.get.query().length;
						$search.val(text.substr(0, length));
					},
					scrollPosition: function($item, forceScroll) {
						var edgeTolerance = 5,
							$menu,
							hasActive,
							offset,
							itemHeight,
							itemOffset,
							menuOffset,
							menuScroll,
							menuHeight,
							abovePage,
							belowPage;

						$item = $item || module.get.selectedItem();
						$menu = $item.closest(selector.menu);
						hasActive = $item && $item.length > 0;
						forceScroll =
							forceScroll !== undefined ? forceScroll : false;
						if ($item && $menu.length > 0 && hasActive) {
							itemOffset = $item.position().top;

							$menu.addClass(className.loading);
							menuScroll = $menu.scrollTop();
							menuOffset = $menu.offset().top;
							itemOffset = $item.offset().top;
							offset = menuScroll - menuOffset + itemOffset;
							if (!forceScroll) {
								menuHeight = $menu.height();
								belowPage =
									menuScroll + menuHeight <
									offset + edgeTolerance;
								abovePage = offset - edgeTolerance < menuScroll;
							}
							module.debug("Scrolling to active item", offset);
							if (forceScroll || abovePage || belowPage) {
								$menu.scrollTop(offset);
							}
							$menu.removeClass(className.loading);
						}
					},
					text: function(text) {
						if (settings.action !== "select") {
							if (settings.action == "combo") {
								module.debug(
									"Changing combo button text",
									text,
									$combo
								);
								if (settings.preserveHTML) {
									$combo.html(text);
								} else {
									$combo.text(text);
								}
							} else {
								if (text !== module.get.placeholderText()) {
									$text.removeClass(className.placeholder);
								}
								module.debug("Changing text", text, $text);
								$text.removeClass(className.filtered);
								if (settings.preserveHTML) {
									$text.html(text);
								} else {
									$text.text(text);
								}
							}
						}
					},
					selectedItem: function($item) {
						var value = module.get.choiceValue($item),
							searchText = module.get.choiceText($item, false),
							text = module.get.choiceText($item, true);
						module.debug("Setting user selection to item", $item);
						module.remove.activeItem();
						module.set.partialSearch(searchText);
						module.set.activeItem($item);
						module.set.selected(value, $item);
						module.set.text(text);
					},
					selectedLetter: function(letter) {
						var $selectedItem = $item.filter(
								"." + className.selected
							),
							alreadySelectedLetter =
								$selectedItem.length > 0 &&
								module.has.firstLetter($selectedItem, letter),
							$nextValue = false,
							$nextItem;
						// check next of same letter
						if (alreadySelectedLetter) {
							$nextItem = $selectedItem.nextAll($item).eq(0);
							if (module.has.firstLetter($nextItem, letter)) {
								$nextValue = $nextItem;
							}
						}
						// check all values
						if (!$nextValue) {
							$item.each(function() {
								if (module.has.firstLetter($(this), letter)) {
									$nextValue = $(this);
									return false;
								}
							});
						}
						// set next value
						if ($nextValue) {
							module.verbose(
								"Scrolling to next value with letter",
								letter
							);
							module.set.scrollPosition($nextValue);
							$selectedItem.removeClass(className.selected);
							$nextValue.addClass(className.selected);
							if (
								settings.selectOnKeydown &&
								module.is.single()
							) {
								module.set.selectedItem($nextValue);
							}
						}
					},
					direction: function($menu) {
						if (settings.direction == "auto") {
							// reset position
							module.remove.upward();

							if (module.can.openDownward($menu)) {
								module.remove.upward($menu);
							} else {
								module.set.upward($menu);
							}
							if (
								!module.is.leftward($menu) &&
								!module.can.openRightward($menu)
							) {
								module.set.leftward($menu);
							}
						} else if (settings.direction == "upward") {
							module.set.upward($menu);
						}
					},
					upward: function($currentMenu) {
						var $element = $currentMenu || $module;
						$element.addClass(className.upward);
					},
					leftward: function($currentMenu) {
						var $element = $currentMenu || $menu;
						$element.addClass(className.leftward);
					},
					value: function(value, text, $selected) {
						var escapedValue = module.escape.value(value),
							hasInput = $input.length > 0,
							currentValue = module.get.values(),
							stringValue =
								value !== undefined ? String(value) : value,
							newValue;
						if (hasInput) {
							if (
								!settings.allowReselection &&
								stringValue == currentValue
							) {
								module.verbose(
									"Skipping value update already same value",
									value,
									currentValue
								);
								if (!module.is.initialLoad()) {
									return;
								}
							}

							if (
								module.is.single() &&
								module.has.selectInput() &&
								module.can.extendSelect()
							) {
								module.debug("Adding user option", value);
								module.add.optionValue(value);
							}
							module.debug(
								"Updating input value",
								escapedValue,
								currentValue
							);
							internalChange = true;
							$input.val(escapedValue);
							if (
								settings.fireOnInit === false &&
								module.is.initialLoad()
							) {
								module.debug(
									"Input native change event ignored on initial load"
								);
							} else {
								module.trigger.change();
							}
							internalChange = false;
						} else {
							module.verbose(
								"Storing value in metadata",
								escapedValue,
								$input
							);
							if (escapedValue !== currentValue) {
								$module.data(metadata.value, stringValue);
							}
						}
						if (module.is.single() && settings.clearable) {
							// treat undefined or '' as empty
							if (!escapedValue) {
								module.remove.clearable();
							} else {
								module.set.clearable();
							}
						}
						if (
							settings.fireOnInit === false &&
							module.is.initialLoad()
						) {
							module.verbose(
								"No callback on initial load",
								settings.onChange
							);
						} else {
							settings.onChange.call(
								element,
								value,
								text,
								$selected
							);
						}
					},
					active: function() {
						$module.addClass(className.active);
					},
					multiple: function() {
						$module.addClass(className.multiple);
					},
					visible: function() {
						$module.addClass(className.visible);
					},
					exactly: function(value, $selectedItem) {
						module.debug("Setting selected to exact values");
						module.clear();
						module.set.selected(value, $selectedItem);
					},
					selected: function(value, $selectedItem) {
						var isMultiple = module.is.multiple(),
							$userSelectedItem;
						$selectedItem = settings.allowAdditions
							? $selectedItem ||
							  module.get.itemWithAdditions(value)
							: $selectedItem || module.get.item(value);
						if (!$selectedItem) {
							return;
						}
						module.debug(
							"Setting selected menu item to",
							$selectedItem
						);
						if (module.is.multiple()) {
							module.remove.searchWidth();
						}
						if (module.is.single()) {
							module.remove.activeItem();
							module.remove.selectedItem();
						} else if (settings.useLabels) {
							module.remove.selectedItem();
						}
						// select each item
						$selectedItem.each(function() {
							var $selected = $(this),
								selectedText = module.get.choiceText($selected),
								selectedValue = module.get.choiceValue(
									$selected,
									selectedText
								),
								isFiltered = $selected.hasClass(
									className.filtered
								),
								isActive = $selected.hasClass(className.active),
								isUserValue = $selected.hasClass(
									className.addition
								),
								shouldAnimate =
									isMultiple && $selectedItem.length == 1;
							if (isMultiple) {
								if (!isActive || isUserValue) {
									if (
										settings.apiSettings &&
										settings.saveRemoteData
									) {
										module.save.remoteData(
											selectedText,
											selectedValue
										);
									}
									if (settings.useLabels) {
										module.add.label(
											selectedValue,
											selectedText,
											shouldAnimate
										);
										module.add.value(
											selectedValue,
											selectedText,
											$selected
										);
										module.set.activeItem($selected);
										module.filterActive();
										module.select.nextAvailable(
											$selectedItem
										);
									} else {
										module.add.value(
											selectedValue,
											selectedText,
											$selected
										);
										module.set.text(
											module.add.variables(message.count)
										);
										module.set.activeItem($selected);
									}
								} else if (!isFiltered) {
									module.debug(
										"Selected active value, removing label"
									);
									module.remove.selected(selectedValue);
								}
							} else {
								if (
									settings.apiSettings &&
									settings.saveRemoteData
								) {
									module.save.remoteData(
										selectedText,
										selectedValue
									);
								}
								module.set.text(selectedText);
								module.set.value(
									selectedValue,
									selectedText,
									$selected
								);
								$selected
									.addClass(className.active)
									.addClass(className.selected);
							}
						});
					},
					clearable: function() {
						$icon.addClass(className.clear);
					}
				},

				add: {
					label: function(value, text, shouldAnimate) {
						var $next = module.is.searchSelection()
								? $search
								: $text,
							escapedValue = module.escape.value(value),
							$label;
						if (settings.ignoreCase) {
							escapedValue = escapedValue.toLowerCase();
						}
						$label = $("<a />")
							.addClass(className.label)
							.attr("data-" + metadata.value, escapedValue)
							.html(templates.label(escapedValue, text));
						$label = settings.onLabelCreate.call(
							$label,
							escapedValue,
							text
						);

						if (module.has.label(value)) {
							module.debug(
								"User selection already exists, skipping",
								escapedValue
							);
							return;
						}
						if (settings.label.variation) {
							$label.addClass(settings.label.variation);
						}
						if (shouldAnimate === true) {
							module.debug("Animating in label", $label);
							$label
								.addClass(className.hidden)
								.insertBefore($next)
								.transition(
									settings.label.transition,
									settings.label.duration
								);
						} else {
							module.debug("Adding selection label", $label);
							$label.insertBefore($next);
						}
					},
					message: function(message) {
						var $message = $menu.children(selector.message),
							html = settings.templates.message(
								module.add.variables(message)
							);
						if ($message.length > 0) {
							$message.html(html);
						} else {
							$message = $("<div/>")
								.html(html)
								.addClass(className.message)
								.appendTo($menu);
						}
					},
					optionValue: function(value) {
						var escapedValue = module.escape.value(value),
							$option = $input.find(
								'option[value="' +
									module.escape.string(escapedValue) +
									'"]'
							),
							hasOption = $option.length > 0;
						if (hasOption) {
							return;
						}
						// temporarily disconnect observer
						module.disconnect.selectObserver();
						if (module.is.single()) {
							module.verbose("Removing previous user addition");
							$input
								.find("option." + className.addition)
								.remove();
						}
						$("<option/>")
							.prop("value", escapedValue)
							.addClass(className.addition)
							.html(value)
							.appendTo($input);
						module.verbose(
							"Adding user addition as an <option>",
							value
						);
						module.observe.select();
					},
					userSuggestion: function(value) {
						var $addition = $menu.children(selector.addition),
							$existingItem = module.get.item(value),
							alreadyHasValue =
								$existingItem &&
								$existingItem.not(selector.addition).length,
							hasUserSuggestion = $addition.length > 0,
							html;
						if (settings.useLabels && module.has.maxSelections()) {
							return;
						}
						if (value === "" || alreadyHasValue) {
							$addition.remove();
							return;
						}
						if (hasUserSuggestion) {
							$addition
								.data(metadata.value, value)
								.data(metadata.text, value)
								.attr("data-" + metadata.value, value)
								.attr("data-" + metadata.text, value)
								.removeClass(className.filtered);
							if (!settings.hideAdditions) {
								html = settings.templates.addition(
									module.add.variables(
										message.addResult,
										value
									)
								);
								$addition.html(html);
							}
							module.verbose(
								"Replacing user suggestion with new value",
								$addition
							);
						} else {
							$addition = module.create.userChoice(value);
							$addition.prependTo($menu);
							module.verbose(
								"Adding item choice to menu corresponding with user choice addition",
								$addition
							);
						}
						if (
							!settings.hideAdditions ||
							module.is.allFiltered()
						) {
							$addition
								.addClass(className.selected)
								.siblings()
								.removeClass(className.selected);
						}
						module.refreshItems();
					},
					variables: function(message, term) {
						var hasCount = message.search("{count}") !== -1,
							hasMaxCount = message.search("{maxCount}") !== -1,
							hasTerm = message.search("{term}") !== -1,
							values,
							count,
							query;
						module.verbose(
							"Adding templated variables to message",
							message
						);
						if (hasCount) {
							count = module.get.selectionCount();
							message = message.replace("{count}", count);
						}
						if (hasMaxCount) {
							count = module.get.selectionCount();
							message = message.replace(
								"{maxCount}",
								settings.maxSelections
							);
						}
						if (hasTerm) {
							query = term || module.get.query();
							message = message.replace("{term}", query);
						}
						return message;
					},
					value: function(addedValue, addedText, $selectedItem) {
						var currentValue = module.get.values(),
							newValue;
						if (module.has.value(addedValue)) {
							module.debug("Value already selected");
							return;
						}
						if (addedValue === "") {
							module.debug(
								"Cannot select blank values from multiselect"
							);
							return;
						}
						// extend current array
						if ($.isArray(currentValue)) {
							newValue = currentValue.concat([addedValue]);
							newValue = module.get.uniqueArray(newValue);
						} else {
							newValue = [addedValue];
						}
						// add values
						if (module.has.selectInput()) {
							if (module.can.extendSelect()) {
								module.debug(
									"Adding value to select",
									addedValue,
									newValue,
									$input
								);
								module.add.optionValue(addedValue);
							}
						} else {
							newValue = newValue.join(settings.delimiter);
							module.debug(
								"Setting hidden input to delimited value",
								newValue,
								$input
							);
						}

						if (
							settings.fireOnInit === false &&
							module.is.initialLoad()
						) {
							module.verbose(
								"Skipping onadd callback on initial load",
								settings.onAdd
							);
						} else {
							settings.onAdd.call(
								element,
								addedValue,
								addedText,
								$selectedItem
							);
						}
						module.set.value(
							newValue,
							addedValue,
							addedText,
							$selectedItem
						);
						module.check.maxSelections();
					}
				},

				remove: {
					active: function() {
						$module.removeClass(className.active);
					},
					activeLabel: function() {
						$module
							.find(selector.label)
							.removeClass(className.active);
					},
					empty: function() {
						$module.removeClass(className.empty);
					},
					loading: function() {
						$module.removeClass(className.loading);
					},
					initialLoad: function() {
						initialLoad = false;
					},
					upward: function($currentMenu) {
						var $element = $currentMenu || $module;
						$element.removeClass(className.upward);
					},
					leftward: function($currentMenu) {
						var $element = $currentMenu || $menu;
						$element.removeClass(className.leftward);
					},
					visible: function() {
						$module.removeClass(className.visible);
					},
					activeItem: function() {
						$item.removeClass(className.active);
					},
					filteredItem: function() {
						if (settings.useLabels && module.has.maxSelections()) {
							return;
						}
						if (settings.useLabels && module.is.multiple()) {
							$item
								.not("." + className.active)
								.removeClass(className.filtered);
						} else {
							$item.removeClass(className.filtered);
						}
						module.remove.empty();
					},
					optionValue: function(value) {
						var escapedValue = module.escape.value(value),
							$option = $input.find(
								'option[value="' +
									module.escape.string(escapedValue) +
									'"]'
							),
							hasOption = $option.length > 0;
						if (
							!hasOption ||
							!$option.hasClass(className.addition)
						) {
							return;
						}
						// temporarily disconnect observer
						if (selectObserver) {
							selectObserver.disconnect();
							module.verbose(
								"Temporarily disconnecting mutation observer"
							);
						}
						$option.remove();
						module.verbose(
							"Removing user addition as an <option>",
							escapedValue
						);
						if (selectObserver) {
							selectObserver.observe($input[0], {
								childList: true,
								subtree: true
							});
						}
					},
					message: function() {
						$menu.children(selector.message).remove();
					},
					searchWidth: function() {
						$search.css("width", "");
					},
					searchTerm: function() {
						module.verbose("Cleared search term");
						$search.val("");
						module.set.filtered();
					},
					userAddition: function() {
						$item.filter(selector.addition).remove();
					},
					selected: function(value, $selectedItem) {
						$selectedItem = settings.allowAdditions
							? $selectedItem ||
							  module.get.itemWithAdditions(value)
							: $selectedItem || module.get.item(value);

						if (!$selectedItem) {
							return false;
						}

						$selectedItem.each(function() {
							var $selected = $(this),
								selectedText = module.get.choiceText($selected),
								selectedValue = module.get.choiceValue(
									$selected,
									selectedText
								);
							if (module.is.multiple()) {
								if (settings.useLabels) {
									module.remove.value(
										selectedValue,
										selectedText,
										$selected
									);
									module.remove.label(selectedValue);
								} else {
									module.remove.value(
										selectedValue,
										selectedText,
										$selected
									);
									if (module.get.selectionCount() === 0) {
										module.set.placeholderText();
									} else {
										module.set.text(
											module.add.variables(message.count)
										);
									}
								}
							} else {
								module.remove.value(
									selectedValue,
									selectedText,
									$selected
								);
							}
							$selected
								.removeClass(className.filtered)
								.removeClass(className.active);
							if (settings.useLabels) {
								$selected.removeClass(className.selected);
							}
						});
					},
					selectedItem: function() {
						$item.removeClass(className.selected);
					},
					value: function(removedValue, removedText, $removedItem) {
						var values = module.get.values(),
							newValue;
						if (module.has.selectInput()) {
							module.verbose(
								"Input is <select> removing selected option",
								removedValue
							);
							newValue = module.remove.arrayValue(
								removedValue,
								values
							);
							module.remove.optionValue(removedValue);
						} else {
							module.verbose(
								"Removing from delimited values",
								removedValue
							);
							newValue = module.remove.arrayValue(
								removedValue,
								values
							);
							newValue = newValue.join(settings.delimiter);
						}
						if (
							settings.fireOnInit === false &&
							module.is.initialLoad()
						) {
							module.verbose(
								"No callback on initial load",
								settings.onRemove
							);
						} else {
							settings.onRemove.call(
								element,
								removedValue,
								removedText,
								$removedItem
							);
						}
						module.set.value(newValue, removedText, $removedItem);
						module.check.maxSelections();
					},
					arrayValue: function(removedValue, values) {
						if (!$.isArray(values)) {
							values = [values];
						}
						values = $.grep(values, function(value) {
							return removedValue != value;
						});
						module.verbose(
							"Removed value from delimited string",
							removedValue,
							values
						);
						return values;
					},
					label: function(value, shouldAnimate) {
						var $labels = $module.find(selector.label),
							$removedLabel = $labels.filter(
								"[data-" +
									metadata.value +
									'="' +
									module.escape.string(value) +
									'"]'
							);
						module.verbose("Removing label", $removedLabel);
						$removedLabel.remove();
					},
					activeLabels: function($activeLabels) {
						$activeLabels =
							$activeLabels ||
							$module
								.find(selector.label)
								.filter("." + className.active);
						module.verbose(
							"Removing active label selections",
							$activeLabels
						);
						module.remove.labels($activeLabels);
					},
					labels: function($labels) {
						$labels = $labels || $module.find(selector.label);
						module.verbose("Removing labels", $labels);
						$labels.each(function() {
							var $label = $(this),
								value = $label.data(metadata.value),
								stringValue =
									value !== undefined ? String(value) : value,
								isUserValue = module.is.userValue(stringValue);
							if (
								settings.onLabelRemove.call($label, value) ===
								false
							) {
								module.debug(
									"Label remove callback cancelled removal"
								);
								return;
							}
							module.remove.message();
							if (isUserValue) {
								module.remove.value(stringValue);
								module.remove.label(stringValue);
							} else {
								// selected will also remove label
								module.remove.selected(stringValue);
							}
						});
					},
					tabbable: function() {
						if (module.is.searchSelection()) {
							module.debug("Searchable dropdown initialized");
							$search.removeAttr("tabindex");
							$menu.removeAttr("tabindex");
						} else {
							module.debug(
								"Simple selection dropdown initialized"
							);
							$module.removeAttr("tabindex");
							$menu.removeAttr("tabindex");
						}
					},
					clearable: function() {
						$icon.removeClass(className.clear);
					}
				},

				has: {
					menuSearch: function() {
						return (
							module.has.search() &&
							$search.closest($menu).length > 0
						);
					},
					search: function() {
						return $search.length > 0;
					},
					sizer: function() {
						return $sizer.length > 0;
					},
					selectInput: function() {
						return $input.is("select");
					},
					minCharacters: function(searchTerm) {
						if (settings.minCharacters) {
							searchTerm =
								searchTerm !== undefined
									? String(searchTerm)
									: String(module.get.query());
							return searchTerm.length >= settings.minCharacters;
						}
						return true;
					},
					firstLetter: function($item, letter) {
						var text, firstLetter;
						if (
							!$item ||
							$item.length === 0 ||
							typeof letter !== "string"
						) {
							return false;
						}
						text = module.get.choiceText($item, false);
						letter = letter.toLowerCase();
						firstLetter = String(text)
							.charAt(0)
							.toLowerCase();
						return letter == firstLetter;
					},
					input: function() {
						return $input.length > 0;
					},
					items: function() {
						return $item.length > 0;
					},
					menu: function() {
						return $menu.length > 0;
					},
					message: function() {
						return $menu.children(selector.message).length !== 0;
					},
					label: function(value) {
						var escapedValue = module.escape.value(value),
							$labels = $module.find(selector.label);
						if (settings.ignoreCase) {
							escapedValue = escapedValue.toLowerCase();
						}
						return (
							$labels.filter(
								"[data-" +
									metadata.value +
									'="' +
									module.escape.string(escapedValue) +
									'"]'
							).length > 0
						);
					},
					maxSelections: function() {
						return (
							settings.maxSelections &&
							module.get.selectionCount() >=
								settings.maxSelections
						);
					},
					allResultsFiltered: function() {
						var $normalResults = $item.not(selector.addition);
						return (
							$normalResults.filter(selector.unselectable)
								.length === $normalResults.length
						);
					},
					userSuggestion: function() {
						return $menu.children(selector.addition).length > 0;
					},
					query: function() {
						return module.get.query() !== "";
					},
					value: function(value) {
						return settings.ignoreCase
							? module.has.valueIgnoringCase(value)
							: module.has.valueMatchingCase(value);
					},
					valueMatchingCase: function(value) {
						var values = module.get.values(),
							hasValue = $.isArray(values)
								? values && $.inArray(value, values) !== -1
								: values == value;
						return hasValue ? true : false;
					},
					valueIgnoringCase: function(value) {
						var values = module.get.values(),
							hasValue = false;
						if (!$.isArray(values)) {
							values = [values];
						}
						$.each(values, function(index, existingValue) {
							if (
								String(value).toLowerCase() ==
								String(existingValue).toLowerCase()
							) {
								hasValue = true;
								return false;
							}
						});
						return hasValue;
					}
				},

				is: {
					active: function() {
						return $module.hasClass(className.active);
					},
					animatingInward: function() {
						return $menu.transition("is inward");
					},
					animatingOutward: function() {
						return $menu.transition("is outward");
					},
					bubbledLabelClick: function(event) {
						return (
							$(event.target).is("select, input") &&
							$module.closest("label").length > 0
						);
					},
					bubbledIconClick: function(event) {
						return $(event.target).closest($icon).length > 0;
					},
					alreadySetup: function() {
						return (
							$module.is("select") &&
							$module
								.parent(selector.dropdown)
								.data(moduleNamespace) !== undefined &&
							$module.prev().length === 0
						);
					},
					animating: function($subMenu) {
						return $subMenu
							? $subMenu.transition &&
									$subMenu.transition("is animating")
							: $menu.transition &&
									$menu.transition("is animating");
					},
					leftward: function($subMenu) {
						var $selectedMenu = $subMenu || $menu;
						return $selectedMenu.hasClass(className.leftward);
					},
					disabled: function() {
						return $module.hasClass(className.disabled);
					},
					focused: function() {
						return document.activeElement === $module[0];
					},
					focusedOnSearch: function() {
						return document.activeElement === $search[0];
					},
					allFiltered: function() {
						return (
							(module.is.multiple() || module.has.search()) &&
							!(
								settings.hideAdditions == false &&
								module.has.userSuggestion()
							) &&
							!module.has.message() &&
							module.has.allResultsFiltered()
						);
					},
					hidden: function($subMenu) {
						return !module.is.visible($subMenu);
					},
					initialLoad: function() {
						return initialLoad;
					},
					inObject: function(needle, object) {
						var found = false;
						$.each(object, function(index, property) {
							if (property == needle) {
								found = true;
								return true;
							}
						});
						return found;
					},
					multiple: function() {
						return $module.hasClass(className.multiple);
					},
					remote: function() {
						return settings.apiSettings && module.can.useAPI();
					},
					single: function() {
						return !module.is.multiple();
					},
					selectMutation: function(mutations) {
						var selectChanged = false;
						$.each(mutations, function(index, mutation) {
							if (
								mutation.target &&
								$(mutation.target).is("select")
							) {
								selectChanged = true;
								return true;
							}
						});
						return selectChanged;
					},
					search: function() {
						return $module.hasClass(className.search);
					},
					searchSelection: function() {
						return (
							module.has.search() &&
							$search.parent(selector.dropdown).length === 1
						);
					},
					selection: function() {
						return $module.hasClass(className.selection);
					},
					userValue: function(value) {
						return $.inArray(value, module.get.userValues()) !== -1;
					},
					upward: function($menu) {
						var $element = $menu || $module;
						return $element.hasClass(className.upward);
					},
					visible: function($subMenu) {
						return $subMenu
							? $subMenu.hasClass(className.visible)
							: $menu.hasClass(className.visible);
					},
					verticallyScrollableContext: function() {
						var overflowY =
							$context.get(0) !== window
								? $context.css("overflow-y")
								: false;
						return overflowY == "auto" || overflowY == "scroll";
					},
					horizontallyScrollableContext: function() {
						var overflowX =
							$context.get(0) !== window
								? $context.css("overflow-X")
								: false;
						return overflowX == "auto" || overflowX == "scroll";
					}
				},

				can: {
					activate: function($item) {
						if (settings.useLabels) {
							return true;
						}
						if (!module.has.maxSelections()) {
							return true;
						}
						if (
							module.has.maxSelections() &&
							$item.hasClass(className.active)
						) {
							return true;
						}
						return false;
					},
					openDownward: function($subMenu) {
						var $currentMenu = $subMenu || $menu,
							canOpenDownward = true,
							onScreen = {},
							calculations;
						$currentMenu.addClass(className.loading);
						calculations = {
							context: {
								offset:
									$context.get(0) === window
										? { top: 0, left: 0 }
										: $context.offset(),
								scrollTop: $context.scrollTop(),
								height: $context.outerHeight()
							},
							menu: {
								offset: $currentMenu.offset(),
								height: $currentMenu.outerHeight()
							}
						};
						if (module.is.verticallyScrollableContext()) {
							calculations.menu.offset.top +=
								calculations.context.scrollTop;
						}
						onScreen = {
							above:
								calculations.context.scrollTop <=
								calculations.menu.offset.top -
									calculations.context.offset.top -
									calculations.menu.height,
							below:
								calculations.context.scrollTop +
									calculations.context.height >=
								calculations.menu.offset.top -
									calculations.context.offset.top +
									calculations.menu.height
						};
						if (onScreen.below) {
							module.verbose(
								"Dropdown can fit in context downward",
								onScreen
							);
							canOpenDownward = true;
						} else if (!onScreen.below && !onScreen.above) {
							module.verbose(
								"Dropdown cannot fit in either direction, favoring downward",
								onScreen
							);
							canOpenDownward = true;
						} else {
							module.verbose(
								"Dropdown cannot fit below, opening upward",
								onScreen
							);
							canOpenDownward = false;
						}
						$currentMenu.removeClass(className.loading);
						return canOpenDownward;
					},
					openRightward: function($subMenu) {
						var $currentMenu = $subMenu || $menu,
							canOpenRightward = true,
							isOffscreenRight = false,
							calculations;
						$currentMenu.addClass(className.loading);
						calculations = {
							context: {
								offset:
									$context.get(0) === window
										? { top: 0, left: 0 }
										: $context.offset(),
								scrollLeft: $context.scrollLeft(),
								width: $context.outerWidth()
							},
							menu: {
								offset: $currentMenu.offset(),
								width: $currentMenu.outerWidth()
							}
						};
						if (module.is.horizontallyScrollableContext()) {
							calculations.menu.offset.left +=
								calculations.context.scrollLeft;
						}
						isOffscreenRight =
							calculations.menu.offset.left -
								calculations.context.offset.left +
								calculations.menu.width >=
							calculations.context.scrollLeft +
								calculations.context.width;
						if (isOffscreenRight) {
							module.verbose(
								"Dropdown cannot fit in context rightward",
								isOffscreenRight
							);
							canOpenRightward = false;
						}
						$currentMenu.removeClass(className.loading);
						return canOpenRightward;
					},
					click: function() {
						return hasTouch || settings.on == "click";
					},
					extendSelect: function() {
						return settings.allowAdditions || settings.apiSettings;
					},
					show: function() {
						return (
							!module.is.disabled() &&
							(module.has.items() || module.has.message())
						);
					},
					useAPI: function() {
						return $.fn.api !== undefined;
					}
				},

				animate: {
					show: function(callback, $subMenu) {
						var $currentMenu = $subMenu || $menu,
							start = $subMenu
								? function() {}
								: function() {
										module.hideSubMenus();
										module.hideOthers();
										module.set.active();
								  },
							transition;
						callback = $.isFunction(callback)
							? callback
							: function() {};
						module.verbose(
							"Doing menu show animation",
							$currentMenu
						);
						module.set.direction($subMenu);
						transition = module.get.transition($subMenu);
						if (module.is.selection()) {
							module.set.scrollPosition(
								module.get.selectedItem(),
								true
							);
						}
						if (
							module.is.hidden($currentMenu) ||
							module.is.animating($currentMenu)
						) {
							if (transition == "none") {
								start();
								$currentMenu.transition("show");
								callback.call(element);
							} else if (
								$.fn.transition !== undefined &&
								$module.transition("is supported")
							) {
								$currentMenu.transition({
									animation: transition + " in",
									debug: settings.debug,
									verbose: settings.verbose,
									duration: settings.duration,
									queue: true,
									onStart: start,
									onComplete: function() {
										callback.call(element);
									}
								});
							} else {
								module.error(error.noTransition, transition);
							}
						}
					},
					hide: function(callback, $subMenu) {
						var $currentMenu = $subMenu || $menu,
							duration = $subMenu
								? settings.duration * 0.9
								: settings.duration,
							start = $subMenu
								? function() {}
								: function() {
										if (module.can.click()) {
											module.unbind.intent();
										}
										module.remove.active();
								  },
							transition = module.get.transition($subMenu);
						callback = $.isFunction(callback)
							? callback
							: function() {};
						if (
							module.is.visible($currentMenu) ||
							module.is.animating($currentMenu)
						) {
							module.verbose(
								"Doing menu hide animation",
								$currentMenu
							);

							if (transition == "none") {
								start();
								$currentMenu.transition("hide");
								callback.call(element);
							} else if (
								$.fn.transition !== undefined &&
								$module.transition("is supported")
							) {
								$currentMenu.transition({
									animation: transition + " out",
									duration: settings.duration,
									debug: settings.debug,
									verbose: settings.verbose,
									queue: false,
									onStart: start,
									onComplete: function() {
										callback.call(element);
									}
								});
							} else {
								module.error(error.transition);
							}
						}
					}
				},

				hideAndClear: function() {
					module.remove.searchTerm();
					if (module.has.maxSelections()) {
						return;
					}
					if (module.has.search()) {
						module.hide(function() {
							module.remove.filteredItem();
						});
					} else {
						module.hide();
					}
				},

				delay: {
					show: function() {
						module.verbose(
							"Delaying show event to ensure user intent"
						);
						clearTimeout(module.timer);
						module.timer = setTimeout(
							module.show,
							settings.delay.show
						);
					},
					hide: function() {
						module.verbose(
							"Delaying hide event to ensure user intent"
						);
						clearTimeout(module.timer);
						module.timer = setTimeout(
							module.hide,
							settings.delay.hide
						);
					}
				},

				escape: {
					value: function(value) {
						var multipleValues = $.isArray(value),
							stringValue = typeof value === "string",
							isUnparsable = !stringValue && !multipleValues,
							hasQuotes =
								stringValue &&
								value.search(regExp.quote) !== -1,
							values = [];
						if (isUnparsable || !hasQuotes) {
							return value;
						}
						module.debug(
							"Encoding quote values for use in select",
							value
						);
						if (multipleValues) {
							$.each(value, function(index, value) {
								values.push(
									value.replace(regExp.quote, "&quot;")
								);
							});
							return values;
						}
						return value.replace(regExp.quote, "&quot;");
					},
					string: function(text) {
						text = String(text);
						return text.replace(regExp.escape, "\\$&");
					}
				},

				setting: function(name, value) {
					module.debug("Changing setting", name, value);
					if ($.isPlainObject(name)) {
						$.extend(true, settings, name);
					} else if (value !== undefined) {
						if ($.isPlainObject(settings[name])) {
							$.extend(true, settings[name], value);
						} else {
							settings[name] = value;
						}
					} else {
						return settings[name];
					}
				},
				internal: function(name, value) {
					if ($.isPlainObject(name)) {
						$.extend(true, module, name);
					} else if (value !== undefined) {
						module[name] = value;
					} else {
						return module[name];
					}
				},
				debug: function() {
					if (!settings.silent && settings.debug) {
						if (settings.performance) {
							module.performance.log(arguments);
						} else {
							module.debug = Function.prototype.bind.call(
								console.info,
								console,
								settings.name + ":"
							);
							module.debug.apply(console, arguments);
						}
					}
				},
				verbose: function() {
					if (
						!settings.silent &&
						settings.verbose &&
						settings.debug
					) {
						if (settings.performance) {
							module.performance.log(arguments);
						} else {
							module.verbose = Function.prototype.bind.call(
								console.info,
								console,
								settings.name + ":"
							);
							module.verbose.apply(console, arguments);
						}
					}
				},
				error: function() {
					if (!settings.silent) {
						module.error = Function.prototype.bind.call(
							console.error,
							console,
							settings.name + ":"
						);
						module.error.apply(console, arguments);
					}
				},
				performance: {
					log: function(message) {
						var currentTime, executionTime, previousTime;
						if (settings.performance) {
							currentTime = new Date().getTime();
							previousTime = time || currentTime;
							executionTime = currentTime - previousTime;
							time = currentTime;
							performance.push({
								Name: message[0],
								Arguments: [].slice.call(message, 1) || "",
								Element: element,
								"Execution Time": executionTime
							});
						}
						clearTimeout(module.performance.timer);
						module.performance.timer = setTimeout(
							module.performance.display,
							500
						);
					},
					display: function() {
						var title = settings.name + ":",
							totalTime = 0;
						time = false;
						clearTimeout(module.performance.timer);
						$.each(performance, function(index, data) {
							totalTime += data["Execution Time"];
						});
						title += " " + totalTime + "ms";
						if (moduleSelector) {
							title += " '" + moduleSelector + "'";
						}
						if (
							(console.group !== undefined ||
								console.table !== undefined) &&
							performance.length > 0
						) {
							console.groupCollapsed(title);
							if (console.table) {
								console.table(performance);
							} else {
								$.each(performance, function(index, data) {
									console.log(
										data["Name"] +
											": " +
											data["Execution Time"] +
											"ms"
									);
								});
							}
							console.groupEnd();
						}
						performance = [];
					}
				},
				invoke: function(query, passedArguments, context) {
					var object = instance,
						maxDepth,
						found,
						response;
					passedArguments = passedArguments || queryArguments;
					context = element || context;
					if (typeof query == "string" && object !== undefined) {
						query = query.split(/[\. ]/);
						maxDepth = query.length - 1;
						$.each(query, function(depth, value) {
							var camelCaseValue =
								depth != maxDepth
									? value +
									  query[depth + 1].charAt(0).toUpperCase() +
									  query[depth + 1].slice(1)
									: query;
							if (
								$.isPlainObject(object[camelCaseValue]) &&
								depth != maxDepth
							) {
								object = object[camelCaseValue];
							} else if (object[camelCaseValue] !== undefined) {
								found = object[camelCaseValue];
								return false;
							} else if (
								$.isPlainObject(object[value]) &&
								depth != maxDepth
							) {
								object = object[value];
							} else if (object[value] !== undefined) {
								found = object[value];
								return false;
							} else {
								module.error(error.method, query);
								return false;
							}
						});
					}
					if ($.isFunction(found)) {
						response = found.apply(context, passedArguments);
					} else if (found !== undefined) {
						response = found;
					}
					if ($.isArray(returnedValue)) {
						returnedValue.push(response);
					} else if (returnedValue !== undefined) {
						returnedValue = [returnedValue, response];
					} else if (response !== undefined) {
						returnedValue = response;
					}
					return found;
				}
			};

			if (methodInvoked) {
				if (instance === undefined) {
					module.initialize();
				}
				module.invoke(query);
			} else {
				if (instance !== undefined) {
					instance.invoke("destroy");
				}
				module.initialize();
			}
		});
		return returnedValue !== undefined ? returnedValue : $allModules;
	};

	$.fn.dropdownX.settings = {
		silent: false,
		debug: false,
		verbose: false,
		performance: true,

		on: "click", // what event should show menu action on item selection
		action: "activate", // action on item selection (nothing, activate, select, combo, hide, function(){})

		values: false, // specify values to use for dropdown

		clearable: false, // whether the value of the dropdown can be cleared

		apiSettings: false,
		selectOnKeydown: true, // Whether selection should occur automatically when keyboard shortcuts used
		minCharacters: 0, // Minimum characters required to trigger API call

		filterRemoteData: false, // Whether API results should be filtered after being returned for query term
		saveRemoteData: true, // Whether remote name/value pairs should be stored in sessionStorage to allow remote data to be restored on page refresh

		throttle: 200, // How long to wait after last user input to search remotely

		context: window, // Context to use when determining if on screen
		direction: "auto", // Whether dropdown should always open in one direction
		keepOnScreen: true, // Whether dropdown should check whether it is on screen before showing

		match: "both", // what to match against with search selection (both, text, or label)
		fullTextSearch: false, // search anywhere in value (set to 'exact' to require exact matches)

		placeholder: "auto", // whether to convert blank <select> values to placeholder text
		preserveHTML: true, // preserve html when selecting value
		sortSelect: false, // sort selection on init

		forceSelection: true, // force a choice on blur with search selection

		allowAdditions: false, // whether multiple select should allow user added values
		ignoreCase: false, // whether to consider values not matching in case to be the same
		hideAdditions: true, // whether or not to hide special message prompting a user they can enter a value

		maxSelections: false, // When set to a number limits the number of selections to this count
		useLabels: true, // whether multiple select should filter currently active selections from choices
		delimiter: ",", // when multiselect uses normal <input> the values will be delimited with this character

		showOnFocus: true, // show menu on focus
		allowReselection: false, // whether current value should trigger callbacks when reselected
		allowTab: true, // add tabindex to element
		allowCategorySelection: false, // allow elements with sub-menus to be selected

		fireOnInit: false, // Whether callbacks should fire when initializing dropdown values

		transition: "auto", // auto transition will slide down or up based on direction
		duration: 200, // duration of transition

		glyphWidth: 1.037, // widest glyph width in em (W is 1.037 em) used to calculate multiselect input width

		// label settings on multi-select
		label: {
			transition: "scale",
			duration: 200,
			variation: false
		},

		// delay before event
		delay: {
			hide: 300,
			show: 200,
			search: 20,
			touch: 50
		},

		/* Callbacks */
		onChange: function(value, text, $selected) {},
		onAdd: function(value, text, $selected) {},
		onRemove: function(value, text, $selected) {},

		onLabelSelect: function($selectedLabels) {},
		onLabelCreate: function(value, text) {
			return $(this);
		},
		onLabelRemove: function(value) {
			return true;
		},
		onNoResults: function(searchTerm) {
			return true;
		},
		onShow: function() {},
		onHide: function() {},

		/* Component */
		name: "Dropdown",
		namespace: "dropdown",

		message: {
			addResult: "Add <b>{term}</b>",
			count: "{count} selected",
			maxSelections: "Max {maxCount} selections",
			noResults: "No results found.",
			serverError: "There was an error contacting the server"
		},

		error: {
			action: "You called a dropdown action that was not defined",
			alreadySetup:
				"Once a select has been initialized behaviors must be called on the created ui dropdown",
			labels:
				"Allowing user additions currently requires the use of labels.",
			missingMultiple:
				"<select> requires multiple property to be set to correctly preserve multiple values",
			method: "The method you called is not defined.",
			noAPI: "The API module is required to load resources remotely",
			noStorage: "Saving remote data requires session storage",
			noTransition:
				"This module requires ui transitions <https://github.com/Semantic-Org/UI-Transition>"
		},

		regExp: {
			escape: /[-[\]{}()*+?.,\\^$|#\s]/g,
			quote: /"/g
		},

		metadata: {
			defaultText: "defaultText",
			defaultValue: "defaultValue",
			placeholderText: "placeholder",
			text: "text",
			value: "value"
		},

		// property names for remote query
		fields: {
			remoteValues: "results", // grouping for api results
			values: "values", // grouping for all dropdown values
			disabled: "disabled", // whether value should be disabled
			name: "name", // displayed dropdown text
			value: "value", // actual dropdown value
			text: "text" // displayed text when selected
		},

		keys: {
			backspace: 8,
			delimiter: 188, // comma
			deleteKey: 46,
			enter: 13,
			escape: 27,
			pageUp: 33,
			pageDown: 34,
			leftArrow: 37,
			upArrow: 38,
			rightArrow: 39,
			downArrow: 40
		},

		selector: {
			addition: ".addition",
			dropdown: ".ui.dropdown",
			hidden: ".hidden",
			icon: "> .dropdown.icon",
			input: '> input[type="hidden"], > select',
			item: ".item",
			label: "> .label",
			remove: "> .label > .delete.icon",
			siblingLabel: ".label",
			menu: ".menu",
			message: ".message",
			menuIcon: ".dropdown.icon",
			search: "input.search, .menu > .search > input, .menu input.search",
			sizer: "> input.sizer",
			text: "> .text:not(.icon)",
			unselectable: ".disabled, .filtered"
		},

		className: {
			active: "active",
			addition: "addition",
			animating: "animating",
			clear: "clear",
			disabled: "disabled",
			empty: "empty",
			dropdown: "ui dropdown",
			filtered: "filtered",
			hidden: "hidden transition",
			item: "item",
			label: "ui label",
			loading: "loading",
			menu: "menu",
			message: "message",
			multiple: "multiple",
			placeholder: "default",
			sizer: "sizer",
			search: "search",
			selected: "selected",
			selection: "selection",
			upward: "upward",
			leftward: "left",
			visible: "visible"
		}
	};

	/* Templates */
	$.fn.dropdownX.settings.templates = {
		// generates dropdown from select values
		dropdown: function(select) {
			var placeholder = select.placeholder || false,
				values = select.values || {},
				html = "";
			html += '<i class="dropdown icon"></i>';
			if (select.placeholder) {
				html += '<div class="default text">' + placeholder + "</div>";
			} else {
				html += '<div class="text"></div>';
			}
			html += '<div class="menu">';
			$.each(select.values, function(index, option) {
				html += option.disabled
					? '<div class="disabled item" data-value="' +
					  option.value +
					  '">' +
					  option.name +
					  "</div>"
					: '<div class="item" data-value="' +
					  option.value +
					  '">' +
					  option.name +
					  "</div>";
			});
			html += "</div>";
			return html;
		},

		// generates just menu from select
		menu: function(response, fields) {
			var values = response[fields.values] || {},
				html = "";
			$.each(values, function(index, option) {
				var maybeText = option[fields.text]
						? 'data-text="' + option[fields.text] + '"'
						: "",
					maybeDisabled = option[fields.disabled] ? "disabled " : "";
				html +=
					'<div class="' +
					maybeDisabled +
					'item" data-value="' +
					option[fields.value] +
					'"' +
					maybeText +
					">";
				html += option[fields.name];
				html += "</div>";
			});
			return html;
		},

		// generates label for multiselect
		label: function(value, text) {
			return text + '<i class="delete icon"></i>';
		},

		// generates messages like "No results"
		message: function(message) {
			return message;
		},

		// generates user addition to selection menu
		addition: function(choice) {
			return choice;
		}
	};
})(jQuery, window, document);

/*!
 * # Semantic UI 2.4.2 - Embed
 * http://github.com/semantic-org/semantic-ui/
 *
 *
 * Released under the MIT license
 * http://opensource.org/licenses/MIT
 *
 */

;(function ($, window, document, undefined) {

"use strict";

window = (typeof window != 'undefined' && window.Math == Math)
  ? window
  : (typeof self != 'undefined' && self.Math == Math)
    ? self
    : Function('return this')()
;

$.fn.embed = function(parameters) {

  var
    $allModules     = $(this),

    moduleSelector  = $allModules.selector || '',

    time            = new Date().getTime(),
    performance     = [],

    query           = arguments[0],
    methodInvoked   = (typeof query == 'string'),
    queryArguments  = [].slice.call(arguments, 1),

    returnedValue
  ;

  $allModules
    .each(function() {
      var
        settings        = ( $.isPlainObject(parameters) )
          ? $.extend(true, {}, $.fn.embed.settings, parameters)
          : $.extend({}, $.fn.embed.settings),

        selector        = settings.selector,
        className       = settings.className,
        sources         = settings.sources,
        error           = settings.error,
        metadata        = settings.metadata,
        namespace       = settings.namespace,
        templates       = settings.templates,

        eventNamespace  = '.' + namespace,
        moduleNamespace = 'module-' + namespace,

        $window         = $(window),
        $module         = $(this),
        $placeholder    = $module.find(selector.placeholder),
        $icon           = $module.find(selector.icon),
        $embed          = $module.find(selector.embed),

        element         = this,
        instance        = $module.data(moduleNamespace),
        module
      ;

      module = {

        initialize: function() {
          module.debug('Initializing embed');
          module.determine.autoplay();
          module.create();
          module.bind.events();
          module.instantiate();
        },

        instantiate: function() {
          module.verbose('Storing instance of module', module);
          instance = module;
          $module
            .data(moduleNamespace, module)
          ;
        },

        destroy: function() {
          module.verbose('Destroying previous instance of embed');
          module.reset();
          $module
            .removeData(moduleNamespace)
            .off(eventNamespace)
          ;
        },

        refresh: function() {
          module.verbose('Refreshing selector cache');
          $placeholder = $module.find(selector.placeholder);
          $icon        = $module.find(selector.icon);
          $embed       = $module.find(selector.embed);
        },

        bind: {
          events: function() {
            if( module.has.placeholder() ) {
              module.debug('Adding placeholder events');
              $module
                .on('click' + eventNamespace, selector.placeholder, module.createAndShow)
                .on('click' + eventNamespace, selector.icon, module.createAndShow)
              ;
            }
          }
        },

        create: function() {
          var
            placeholder = module.get.placeholder()
          ;
          if(placeholder) {
            module.createPlaceholder();
          }
          else {
            module.createAndShow();
          }
        },

        createPlaceholder: function(placeholder) {
          var
            icon  = module.get.icon(),
            url   = module.get.url(),
            embed = module.generate.embed(url)
          ;
          placeholder = placeholder || module.get.placeholder();
          $module.html( templates.placeholder(placeholder, icon) );
          module.debug('Creating placeholder for embed', placeholder, icon);
        },

        createEmbed: function(url) {
          module.refresh();
          url = url || module.get.url();
          $embed = $('<div/>')
            .addClass(className.embed)
            .html( module.generate.embed(url) )
            .appendTo($module)
          ;
          settings.onCreate.call(element, url);
          module.debug('Creating embed object', $embed);
        },

        changeEmbed: function(url) {
          $embed
            .html( module.generate.embed(url) )
          ;
        },

        createAndShow: function() {
          module.createEmbed();
          module.show();
        },

        // sets new embed
        change: function(source, id, url) {
          module.debug('Changing video to ', source, id, url);
          $module
            .data(metadata.source, source)
            .data(metadata.id, id)
          ;
          if(url) {
            $module.data(metadata.url, url);
          }
          else {
            $module.removeData(metadata.url);
          }
          if(module.has.embed()) {
            module.changeEmbed();
          }
          else {
            module.create();
          }
        },

        // clears embed
        reset: function() {
          module.debug('Clearing embed and showing placeholder');
          module.remove.data();
          module.remove.active();
          module.remove.embed();
          module.showPlaceholder();
          settings.onReset.call(element);
        },

        // shows current embed
        show: function() {
          module.debug('Showing embed');
          module.set.active();
          settings.onDisplay.call(element);
        },

        hide: function() {
          module.debug('Hiding embed');
          module.showPlaceholder();
        },

        showPlaceholder: function() {
          module.debug('Showing placeholder image');
          module.remove.active();
          settings.onPlaceholderDisplay.call(element);
        },

        get: {
          id: function() {
            return settings.id || $module.data(metadata.id);
          },
          placeholder: function() {
            return settings.placeholder || $module.data(metadata.placeholder);
          },
          icon: function() {
            return (settings.icon)
              ? settings.icon
              : ($module.data(metadata.icon) !== undefined)
                ? $module.data(metadata.icon)
                : module.determine.icon()
            ;
          },
          source: function(url) {
            return (settings.source)
              ? settings.source
              : ($module.data(metadata.source) !== undefined)
                ? $module.data(metadata.source)
                : module.determine.source()
            ;
          },
          type: function() {
            var source = module.get.source();
            return (sources[source] !== undefined)
              ? sources[source].type
              : false
            ;
          },
          url: function() {
            return (settings.url)
              ? settings.url
              : ($module.data(metadata.url) !== undefined)
                ? $module.data(metadata.url)
                : module.determine.url()
            ;
          }
        },

        determine: {
          autoplay: function() {
            if(module.should.autoplay()) {
              settings.autoplay = true;
            }
          },
          source: function(url) {
            var
              matchedSource = false
            ;
            url = url || module.get.url();
            if(url) {
              $.each(sources, function(name, source) {
                if(url.search(source.domain) !== -1) {
                  matchedSource = name;
                  return false;
                }
              });
            }
            return matchedSource;
          },
          icon: function() {
            var
              source = module.get.source()
            ;
            return (sources[source] !== undefined)
              ? sources[source].icon
              : false
            ;
          },
          url: function() {
            var
              id     = settings.id     || $module.data(metadata.id),
              source = settings.source || $module.data(metadata.source),
              url
            ;
            url = (sources[source] !== undefined)
              ? sources[source].url.replace('{id}', id)
              : false
            ;
            if(url) {
              $module.data(metadata.url, url);
            }
            return url;
          }
        },


        set: {
          active: function() {
            $module.addClass(className.active);
          }
        },

        remove: {
          data: function() {
            $module
              .removeData(metadata.id)
              .removeData(metadata.icon)
              .removeData(metadata.placeholder)
              .removeData(metadata.source)
              .removeData(metadata.url)
            ;
          },
          active: function() {
            $module.removeClass(className.active);
          },
          embed: function() {
            $embed.empty();
          }
        },

        encode: {
          parameters: function(parameters) {
            var
              urlString = [],
              index
            ;
            for (index in parameters) {
              urlString.push( encodeURIComponent(index) + '=' + encodeURIComponent( parameters[index] ) );
            }
            return urlString.join('&amp;');
          }
        },

        generate: {
          embed: function(url) {
            module.debug('Generating embed html');
            var
              source = module.get.source(),
              html,
              parameters
            ;
            url = module.get.url(url);
            if(url) {
              parameters = module.generate.parameters(source);
              html       = templates.iframe(url, parameters);
            }
            else {
              module.error(error.noURL, $module);
            }
            return html;
          },
          parameters: function(source, extraParameters) {
            var
              parameters = (sources[source] && sources[source].parameters !== undefined)
                ? sources[source].parameters(settings)
                : {}
            ;
            extraParameters = extraParameters || settings.parameters;
            if(extraParameters) {
              parameters = $.extend({}, parameters, extraParameters);
            }
            parameters = settings.onEmbed(parameters);
            return module.encode.parameters(parameters);
          }
        },

        has: {
          embed: function() {
            return ($embed.length > 0);
          },
          placeholder: function() {
            return settings.placeholder || $module.data(metadata.placeholder);
          }
        },

        should: {
          autoplay: function() {
            return (settings.autoplay === 'auto')
              ? (settings.placeholder || $module.data(metadata.placeholder) !== undefined)
              : settings.autoplay
            ;
          }
        },

        is: {
          video: function() {
            return module.get.type() == 'video';
          }
        },

        setting: function(name, value) {
          module.debug('Changing setting', name, value);
          if( $.isPlainObject(name) ) {
            $.extend(true, settings, name);
          }
          else if(value !== undefined) {
            if($.isPlainObject(settings[name])) {
              $.extend(true, settings[name], value);
            }
            else {
              settings[name] = value;
            }
          }
          else {
            return settings[name];
          }
        },
        internal: function(name, value) {
          if( $.isPlainObject(name) ) {
            $.extend(true, module, name);
          }
          else if(value !== undefined) {
            module[name] = value;
          }
          else {
            return module[name];
          }
        },
        debug: function() {
          if(!settings.silent && settings.debug) {
            if(settings.performance) {
              module.performance.log(arguments);
            }
            else {
              module.debug = Function.prototype.bind.call(console.info, console, settings.name + ':');
              module.debug.apply(console, arguments);
            }
          }
        },
        verbose: function() {
          if(!settings.silent && settings.verbose && settings.debug) {
            if(settings.performance) {
              module.performance.log(arguments);
            }
            else {
              module.verbose = Function.prototype.bind.call(console.info, console, settings.name + ':');
              module.verbose.apply(console, arguments);
            }
          }
        },
        error: function() {
          if(!settings.silent) {
            module.error = Function.prototype.bind.call(console.error, console, settings.name + ':');
            module.error.apply(console, arguments);
          }
        },
        performance: {
          log: function(message) {
            var
              currentTime,
              executionTime,
              previousTime
            ;
            if(settings.performance) {
              currentTime   = new Date().getTime();
              previousTime  = time || currentTime;
              executionTime = currentTime - previousTime;
              time          = currentTime;
              performance.push({
                'Name'           : message[0],
                'Arguments'      : [].slice.call(message, 1) || '',
                'Element'        : element,
                'Execution Time' : executionTime
              });
            }
            clearTimeout(module.performance.timer);
            module.performance.timer = setTimeout(module.performance.display, 500);
          },
          display: function() {
            var
              title = settings.name + ':',
              totalTime = 0
            ;
            time = false;
            clearTimeout(module.performance.timer);
            $.each(performance, function(index, data) {
              totalTime += data['Execution Time'];
            });
            title += ' ' + totalTime + 'ms';
            if(moduleSelector) {
              title += ' \'' + moduleSelector + '\'';
            }
            if($allModules.length > 1) {
              title += ' ' + '(' + $allModules.length + ')';
            }
            if( (console.group !== undefined || console.table !== undefined) && performance.length > 0) {
              console.groupCollapsed(title);
              if(console.table) {
                console.table(performance);
              }
              else {
                $.each(performance, function(index, data) {
                  console.log(data['Name'] + ': ' + data['Execution Time']+'ms');
                });
              }
              console.groupEnd();
            }
            performance = [];
          }
        },
        invoke: function(query, passedArguments, context) {
          var
            object = instance,
            maxDepth,
            found,
            response
          ;
          passedArguments = passedArguments || queryArguments;
          context         = element         || context;
          if(typeof query == 'string' && object !== undefined) {
            query    = query.split(/[\. ]/);
            maxDepth = query.length - 1;
            $.each(query, function(depth, value) {
              var camelCaseValue = (depth != maxDepth)
                ? value + query[depth + 1].charAt(0).toUpperCase() + query[depth + 1].slice(1)
                : query
              ;
              if( $.isPlainObject( object[camelCaseValue] ) && (depth != maxDepth) ) {
                object = object[camelCaseValue];
              }
              else if( object[camelCaseValue] !== undefined ) {
                found = object[camelCaseValue];
                return false;
              }
              else if( $.isPlainObject( object[value] ) && (depth != maxDepth) ) {
                object = object[value];
              }
              else if( object[value] !== undefined ) {
                found = object[value];
                return false;
              }
              else {
                module.error(error.method, query);
                return false;
              }
            });
          }
          if ( $.isFunction( found ) ) {
            response = found.apply(context, passedArguments);
          }
          else if(found !== undefined) {
            response = found;
          }
          if($.isArray(returnedValue)) {
            returnedValue.push(response);
          }
          else if(returnedValue !== undefined) {
            returnedValue = [returnedValue, response];
          }
          else if(response !== undefined) {
            returnedValue = response;
          }
          return found;
        }
      };

      if(methodInvoked) {
        if(instance === undefined) {
          module.initialize();
        }
        module.invoke(query);
      }
      else {
        if(instance !== undefined) {
          instance.invoke('destroy');
        }
        module.initialize();
      }
    })
  ;
  return (returnedValue !== undefined)
    ? returnedValue
    : this
  ;
};

$.fn.embed.settings = {

  name        : 'Embed',
  namespace   : 'embed',

  silent      : false,
  debug       : false,
  verbose     : false,
  performance : true,

  icon     : false,
  source   : false,
  url      : false,
  id       : false,

  // standard video settings
  autoplay  : 'auto',
  color     : '#444444',
  hd        : true,
  brandedUI : false,

  // additional parameters to include with the embed
  parameters: false,

  onDisplay            : function() {},
  onPlaceholderDisplay : function() {},
  onReset              : function() {},
  onCreate             : function(url) {},
  onEmbed              : function(parameters) {
    return parameters;
  },

  metadata    : {
    id          : 'id',
    icon        : 'icon',
    placeholder : 'placeholder',
    source      : 'source',
    url         : 'url'
  },

  error : {
    noURL  : 'No URL specified',
    method : 'The method you called is not defined'
  },

  className : {
    active : 'active',
    embed  : 'embed'
  },

  selector : {
    embed       : '.embed',
    placeholder : '.placeholder',
    icon        : '.icon'
  },

  sources: {
    youtube: {
      name   : 'youtube',
      type   : 'video',
      icon   : 'video play',
      domain : 'youtube.com',
      url    : '//www.youtube.com/embed/{id}',
      parameters: function(settings) {
        return {
          autohide       : !settings.brandedUI,
          autoplay       : settings.autoplay,
          color          : settings.color || undefined,
          hq             : settings.hd,
          jsapi          : settings.api,
          modestbranding : !settings.brandedUI
        };
      }
    },
    vimeo: {
      name   : 'vimeo',
      type   : 'video',
      icon   : 'video play',
      domain : 'vimeo.com',
      url    : '//player.vimeo.com/video/{id}',
      parameters: function(settings) {
        return {
          api      : settings.api,
          autoplay : settings.autoplay,
          byline   : settings.brandedUI,
          color    : settings.color || undefined,
          portrait : settings.brandedUI,
          title    : settings.brandedUI
        };
      }
    }
  },

  templates: {
    iframe : function(url, parameters) {
      var src = url;
      if (parameters) {
          src += '?' + parameters;
      }
      return ''
        + '<iframe src="' + src + '"'
        + ' width="100%" height="100%"'
        + ' frameborder="0" scrolling="no" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>'
      ;
    },
    placeholder : function(image, icon) {
      var
        html = ''
      ;
      if(icon) {
        html += '<i class="' + icon + ' icon"></i>';
      }
      if(image) {
        html += '<img class="placeholder" src="' + image + '">';
      }
      return html;
    }
  },

  // NOT YET IMPLEMENTED
  api     : false,
  onPause : function() {},
  onPlay  : function() {},
  onStop  : function() {}

};



})( jQuery, window, document );

/*!
 * # Semantic UI 2.4.2 - Modal
 * http://github.com/semantic-org/semantic-ui/
 *
 *
 * Released under the MIT license
 * http://opensource.org/licenses/MIT
 *
 */

;(function ($, window, document, undefined) {

'use strict';

window = (typeof window != 'undefined' && window.Math == Math)
  ? window
  : (typeof self != 'undefined' && self.Math == Math)
    ? self
    : Function('return this')()
;

$.fn.modal = function(parameters) {
  var
    $allModules    = $(this),
    $window        = $(window),
    $document      = $(document),
    $body          = $('body'),

    moduleSelector = $allModules.selector || '',

    time           = new Date().getTime(),
    performance    = [],

    query          = arguments[0],
    methodInvoked  = (typeof query == 'string'),
    queryArguments = [].slice.call(arguments, 1),

    requestAnimationFrame = window.requestAnimationFrame
      || window.mozRequestAnimationFrame
      || window.webkitRequestAnimationFrame
      || window.msRequestAnimationFrame
      || function(callback) { setTimeout(callback, 0); },

    returnedValue
  ;

  $allModules
    .each(function() {
      var
        settings    = ( $.isPlainObject(parameters) )
          ? $.extend(true, {}, $.fn.modal.settings, parameters)
          : $.extend({}, $.fn.modal.settings),

        selector        = settings.selector,
        className       = settings.className,
        namespace       = settings.namespace,
        error           = settings.error,

        eventNamespace  = '.' + namespace,
        moduleNamespace = 'module-' + namespace,

        $module         = $(this),
        $context        = $(settings.context),
        $close          = $module.find(selector.close),

        $allModals,
        $otherModals,
        $focusedElement,
        $dimmable,
        $dimmer,

        element         = this,
        instance        = $module.data(moduleNamespace),

        ignoreRepeatedEvents = false,

        elementEventNamespace,
        id,
        observer,
        module
      ;
      module  = {

        initialize: function() {
          module.verbose('Initializing dimmer', $context);

          module.create.id();
          module.create.dimmer();
          module.refreshModals();

          module.bind.events();
          if(settings.observeChanges) {
            module.observeChanges();
          }
          module.instantiate();
        },

        instantiate: function() {
          module.verbose('Storing instance of modal');
          instance = module;
          $module
            .data(moduleNamespace, instance)
          ;
        },

        create: {
          dimmer: function() {
            var
              defaultSettings = {
                debug      : settings.debug,
                variation  : settings.centered
                  ? false
                  : 'top aligned',
                dimmerName : 'modals'
              },
              dimmerSettings = $.extend(true, defaultSettings, settings.dimmerSettings)
            ;
            if($.fn.dimmer === undefined) {
              module.error(error.dimmer);
              return;
            }
            module.debug('Creating dimmer');
            $dimmable = $context.dimmer(dimmerSettings);
            if(settings.detachable) {
              module.verbose('Modal is detachable, moving content into dimmer');
              $dimmable.dimmer('add content', $module);
            }
            else {
              module.set.undetached();
            }
            $dimmer = $dimmable.dimmer('get dimmer');
          },
          id: function() {
            id = (Math.random().toString(16) + '000000000').substr(2, 8);
            elementEventNamespace = '.' + id;
            module.verbose('Creating unique id for element', id);
          }
        },

        destroy: function() {
          module.verbose('Destroying previous modal');
          $module
            .removeData(moduleNamespace)
            .off(eventNamespace)
          ;
          $window.off(elementEventNamespace);
          $dimmer.off(elementEventNamespace);
          $close.off(eventNamespace);
          $context.dimmer('destroy');
        },

        observeChanges: function() {
          if('MutationObserver' in window) {
            observer = new MutationObserver(function(mutations) {
              module.debug('DOM tree modified, refreshing');
              module.refresh();
            });
            observer.observe(element, {
              childList : true,
              subtree   : true
            });
            module.debug('Setting up mutation observer', observer);
          }
        },

        refresh: function() {
          module.remove.scrolling();
          module.cacheSizes();
          if(!module.can.useFlex()) {
            module.set.modalOffset();
          }
          module.set.screenHeight();
          module.set.type();
        },

        refreshModals: function() {
          $otherModals = $module.siblings(selector.modal);
          $allModals   = $otherModals.add($module);
        },

        attachEvents: function(selector, event) {
          var
            $toggle = $(selector)
          ;
          event = $.isFunction(module[event])
            ? module[event]
            : module.toggle
          ;
          if($toggle.length > 0) {
            module.debug('Attaching modal events to element', selector, event);
            $toggle
              .off(eventNamespace)
              .on('click' + eventNamespace, event)
            ;
          }
          else {
            module.error(error.notFound, selector);
          }
        },

        bind: {
          events: function() {
            module.verbose('Attaching events');
            $module
              .on('click' + eventNamespace, selector.close, module.event.close)
              .on('click' + eventNamespace, selector.approve, module.event.approve)
              .on('click' + eventNamespace, selector.deny, module.event.deny)
            ;
            $window
              .on('resize' + elementEventNamespace, module.event.resize)
            ;
          },
          scrollLock: function() {
            // touch events default to passive, due to changes in chrome to optimize mobile perf
            $dimmable.get(0).addEventListener('touchmove', module.event.preventScroll, { passive: false });
          }
        },

        unbind: {
          scrollLock: function() {
            $dimmable.get(0).removeEventListener('touchmove', module.event.preventScroll, { passive: false });
          }
        },

        get: {
          id: function() {
            return (Math.random().toString(16) + '000000000').substr(2, 8);
          }
        },

        event: {
          approve: function() {
            if(ignoreRepeatedEvents || settings.onApprove.call(element, $(this)) === false) {
              module.verbose('Approve callback returned false cancelling hide');
              return;
            }
            ignoreRepeatedEvents = true;
            module.hide(function() {
              ignoreRepeatedEvents = false;
            });
          },
          preventScroll: function(event) {
            event.preventDefault();
          },
          deny: function() {
            if(ignoreRepeatedEvents || settings.onDeny.call(element, $(this)) === false) {
              module.verbose('Deny callback returned false cancelling hide');
              return;
            }
            ignoreRepeatedEvents = true;
            module.hide(function() {
              ignoreRepeatedEvents = false;
            });
          },
          close: function() {
            module.hide();
          },
          click: function(event) {
            if(!settings.closable) {
              module.verbose('Dimmer clicked but closable setting is disabled');
              return;
            }
            var
              $target   = $(event.target),
              isInModal = ($target.closest(selector.modal).length > 0),
              isInDOM   = $.contains(document.documentElement, event.target)
            ;
            if(!isInModal && isInDOM && module.is.active()) {
              module.debug('Dimmer clicked, hiding all modals');
              module.remove.clickaway();
              if(settings.allowMultiple) {
                module.hide();
              }
              else {
                module.hideAll();
              }
            }
          },
          debounce: function(method, delay) {
            clearTimeout(module.timer);
            module.timer = setTimeout(method, delay);
          },
          keyboard: function(event) {
            var
              keyCode   = event.which,
              escapeKey = 27
            ;
            if(keyCode == escapeKey) {
              if(settings.closable) {
                module.debug('Escape key pressed hiding modal');
                module.hide();
              }
              else {
                module.debug('Escape key pressed, but closable is set to false');
              }
              event.preventDefault();
            }
          },
          resize: function() {
            if( $dimmable.dimmer('is active') && ( module.is.animating() || module.is.active() ) ) {
              requestAnimationFrame(module.refresh);
            }
          }
        },

        toggle: function() {
          if( module.is.active() || module.is.animating() ) {
            module.hide();
          }
          else {
            module.show();
          }
        },

        show: function(callback) {
          callback = $.isFunction(callback)
            ? callback
            : function(){}
          ;
          module.refreshModals();
          module.set.dimmerSettings();
          module.set.dimmerStyles();

          module.showModal(callback);
        },

        hide: function(callback) {
          callback = $.isFunction(callback)
            ? callback
            : function(){}
          ;
          module.refreshModals();
          module.hideModal(callback);
        },

        showModal: function(callback) {
          callback = $.isFunction(callback)
            ? callback
            : function(){}
          ;
          if( module.is.animating() || !module.is.active() ) {
            module.showDimmer();
            module.cacheSizes();
            if(module.can.useFlex()) {
              module.remove.legacy();
            }
            else {
              module.set.legacy();
              module.set.modalOffset();
              module.debug('Using non-flex legacy modal positioning.');
            }
            module.set.screenHeight();
            module.set.type();
            module.set.clickaway();

            if( !settings.allowMultiple && module.others.active() ) {
              module.hideOthers(module.showModal);
            }
            else {
              if(settings.allowMultiple && settings.detachable) {
                $module.detach().appendTo($dimmer);
              }
              settings.onShow.call(element);
              if(settings.transition && $.fn.transition !== undefined && $module.transition('is supported')) {
                module.debug('Showing modal with css animations');
                $module
                  .transition({
                    debug       : settings.debug,
                    animation   : settings.transition + ' in',
                    queue       : settings.queue,
                    duration    : settings.duration,
                    useFailSafe : true,
                    onComplete : function() {
                      settings.onVisible.apply(element);
                      if(settings.keyboardShortcuts) {
                        module.add.keyboardShortcuts();
                      }
                      module.save.focus();
                      module.set.active();
                      if(settings.autofocus) {
                        module.set.autofocus();
                      }
                      callback();
                    }
                  })
                ;
              }
              else {
                module.error(error.noTransition);
              }
            }
          }
          else {
            module.debug('Modal is already visible');
          }
        },

        hideModal: function(callback, keepDimmed) {
          callback = $.isFunction(callback)
            ? callback
            : function(){}
          ;
          module.debug('Hiding modal');
          if(settings.onHide.call(element, $(this)) === false) {
            module.verbose('Hide callback returned false cancelling hide');
            return;
          }

          if( module.is.animating() || module.is.active() ) {
            if(settings.transition && $.fn.transition !== undefined && $module.transition('is supported')) {
              module.remove.active();
              $module
                .transition({
                  debug       : settings.debug,
                  animation   : settings.transition + ' out',
                  queue       : settings.queue,
                  duration    : settings.duration,
                  useFailSafe : true,
                  onStart     : function() {
                    if(!module.others.active() && !keepDimmed) {
                      module.hideDimmer();
                    }
                    if(settings.keyboardShortcuts) {
                      module.remove.keyboardShortcuts();
                    }
                  },
                  onComplete : function() {
                    settings.onHidden.call(element);
                    module.remove.dimmerStyles();
                    module.restore.focus();
                    callback();
                  }
                })
              ;
            }
            else {
              module.error(error.noTransition);
            }
          }
        },

        showDimmer: function() {
          if($dimmable.dimmer('is animating') || !$dimmable.dimmer('is active') ) {
            module.debug('Showing dimmer');
            $dimmable.dimmer('show');
          }
          else {
            module.debug('Dimmer already visible');
          }
        },

        hideDimmer: function() {
          if( $dimmable.dimmer('is animating') || ($dimmable.dimmer('is active')) ) {
            module.unbind.scrollLock();
            $dimmable.dimmer('hide', function() {
              module.remove.clickaway();
              module.remove.screenHeight();
            });
          }
          else {
            module.debug('Dimmer is not visible cannot hide');
            return;
          }
        },

        hideAll: function(callback) {
          var
            $visibleModals = $allModals.filter('.' + className.active + ', .' + className.animating)
          ;
          callback = $.isFunction(callback)
            ? callback
            : function(){}
          ;
          if( $visibleModals.length > 0 ) {
            module.debug('Hiding all visible modals');
            module.hideDimmer();
            $visibleModals
              .modal('hide modal', callback)
            ;
          }
        },

        hideOthers: function(callback) {
          var
            $visibleModals = $otherModals.filter('.' + className.active + ', .' + className.animating)
          ;
          callback = $.isFunction(callback)
            ? callback
            : function(){}
          ;
          if( $visibleModals.length > 0 ) {
            module.debug('Hiding other modals', $otherModals);
            $visibleModals
              .modal('hide modal', callback, true)
            ;
          }
        },

        others: {
          active: function() {
            return ($otherModals.filter('.' + className.active).length > 0);
          },
          animating: function() {
            return ($otherModals.filter('.' + className.animating).length > 0);
          }
        },


        add: {
          keyboardShortcuts: function() {
            module.verbose('Adding keyboard shortcuts');
            $document
              .on('keyup' + eventNamespace, module.event.keyboard)
            ;
          }
        },

        save: {
          focus: function() {
            var
              $activeElement = $(document.activeElement),
              inCurrentModal = $activeElement.closest($module).length > 0
            ;
            if(!inCurrentModal) {
              $focusedElement = $(document.activeElement).blur();
            }
          }
        },

        restore: {
          focus: function() {
            if($focusedElement && $focusedElement.length > 0) {
              $focusedElement.focus();
            }
          }
        },

        remove: {
          active: function() {
            $module.removeClass(className.active);
          },
          legacy: function() {
            $module.removeClass(className.legacy);
          },
          clickaway: function() {
            $dimmer
              .off('click' + elementEventNamespace)
            ;
          },
          dimmerStyles: function() {
            $dimmer.removeClass(className.inverted);
            $dimmable.removeClass(className.blurring);
          },
          bodyStyle: function() {
            if($body.attr('style') === '') {
              module.verbose('Removing style attribute');
              $body.removeAttr('style');
            }
          },
          screenHeight: function() {
            module.debug('Removing page height');
            $body
              .css('height', '')
            ;
          },
          keyboardShortcuts: function() {
            module.verbose('Removing keyboard shortcuts');
            $document
              .off('keyup' + eventNamespace)
            ;
          },
          scrolling: function() {
            $dimmable.removeClass(className.scrolling);
            $module.removeClass(className.scrolling);
          }
        },

        cacheSizes: function() {
          $module.addClass(className.loading);
          var
            scrollHeight = $module.prop('scrollHeight'),
            modalWidth   = $module.outerWidth(),
            modalHeight  = $module.outerHeight()
          ;
          if(module.cache === undefined || modalHeight !== 0) {
            module.cache = {
              pageHeight    : $(document).outerHeight(),
              width         : modalWidth,
              height        : modalHeight + settings.offset,
              scrollHeight  : scrollHeight + settings.offset,
              contextHeight : (settings.context == 'body')
                ? $(window).height()
                : $dimmable.height(),
            };
            module.cache.topOffset = -(module.cache.height / 2);
          }
          $module.removeClass(className.loading);
          module.debug('Caching modal and container sizes', module.cache);
        },

        can: {
          useFlex: function() {
            return (settings.useFlex == 'auto')
              ? settings.detachable && !module.is.ie()
              : settings.useFlex
            ;
          },
          fit: function() {
            var
              contextHeight  = module.cache.contextHeight,
              verticalCenter = module.cache.contextHeight / 2,
              topOffset      = module.cache.topOffset,
              scrollHeight   = module.cache.scrollHeight,
              height         = module.cache.height,
              paddingHeight  = settings.padding,
              startPosition  = (verticalCenter + topOffset)
            ;
            return (scrollHeight > height)
              ? (startPosition + scrollHeight + paddingHeight < contextHeight)
              : (height + (paddingHeight * 2) < contextHeight)
            ;
          }
        },

        is: {
          active: function() {
            return $module.hasClass(className.active);
          },
          ie: function() {
            var
              isIE11 = (!(window.ActiveXObject) && 'ActiveXObject' in window),
              isIE   = ('ActiveXObject' in window)
            ;
            return (isIE11 || isIE);
          },
          animating: function() {
            return $module.transition('is supported')
              ? $module.transition('is animating')
              : $module.is(':visible')
            ;
          },
          scrolling: function() {
            return $dimmable.hasClass(className.scrolling);
          },
          modernBrowser: function() {
            // appName for IE11 reports 'Netscape' can no longer use
            return !(window.ActiveXObject || 'ActiveXObject' in window);
          }
        },

        set: {
          autofocus: function() {
            var
              $inputs    = $module.find('[tabindex], :input').filter(':visible'),
              $autofocus = $inputs.filter('[autofocus]'),
              $input     = ($autofocus.length > 0)
                ? $autofocus.first()
                : $inputs.first()
            ;
            if($input.length > 0) {
              $input.focus();
            }
          },
          clickaway: function() {
            $dimmer
              .on('click' + elementEventNamespace, module.event.click)
            ;
          },
          dimmerSettings: function() {
            if($.fn.dimmer === undefined) {
              module.error(error.dimmer);
              return;
            }
            var
              defaultSettings = {
                debug      : settings.debug,
                dimmerName : 'modals',
                closable   : 'auto',
                useFlex    : module.can.useFlex(),
                variation  : settings.centered
                  ? false
                  : 'top aligned',
                duration   : {
                  show     : settings.duration,
                  hide     : settings.duration
                }
              },
              dimmerSettings = $.extend(true, defaultSettings, settings.dimmerSettings)
            ;
            if(settings.inverted) {
              dimmerSettings.variation = (dimmerSettings.variation !== undefined)
                ? dimmerSettings.variation + ' inverted'
                : 'inverted'
              ;
            }
            $context.dimmer('setting', dimmerSettings);
          },
          dimmerStyles: function() {
            if(settings.inverted) {
              $dimmer.addClass(className.inverted);
            }
            else {
              $dimmer.removeClass(className.inverted);
            }
            if(settings.blurring) {
              $dimmable.addClass(className.blurring);
            }
            else {
              $dimmable.removeClass(className.blurring);
            }
          },
          modalOffset: function() {
            var
              width = module.cache.width,
              height = module.cache.height
            ;
            $module
              .css({
                marginTop: (settings.centered && module.can.fit())
                  ? -(height / 2)
                  : 0,
                marginLeft: -(width / 2)
              })
            ;
            module.verbose('Setting modal offset for legacy mode');
          },
          screenHeight: function() {
            if( module.can.fit() ) {
              $body.css('height', '');
            }
            else {
              module.debug('Modal is taller than page content, resizing page height');
              $body
                .css('height', module.cache.height + (settings.padding * 2) )
              ;
            }
          },
          active: function() {
            $module.addClass(className.active);
          },
          scrolling: function() {
            $dimmable.addClass(className.scrolling);
            $module.addClass(className.scrolling);
            module.unbind.scrollLock();
          },
          legacy: function() {
            $module.addClass(className.legacy);
          },
          type: function() {
            if(module.can.fit()) {
              module.verbose('Modal fits on screen');
              if(!module.others.active() && !module.others.animating()) {
                module.remove.scrolling();
                module.bind.scrollLock();
              }
            }
            else {
              module.verbose('Modal cannot fit on screen setting to scrolling');
              module.set.scrolling();
            }
          },
          undetached: function() {
            $dimmable.addClass(className.undetached);
          }
        },

        setting: function(name, value) {
          module.debug('Changing setting', name, value);
          if( $.isPlainObject(name) ) {
            $.extend(true, settings, name);
          }
          else if(value !== undefined) {
            if($.isPlainObject(settings[name])) {
              $.extend(true, settings[name], value);
            }
            else {
              settings[name] = value;
            }
          }
          else {
            return settings[name];
          }
        },
        internal: function(name, value) {
          if( $.isPlainObject(name) ) {
            $.extend(true, module, name);
          }
          else if(value !== undefined) {
            module[name] = value;
          }
          else {
            return module[name];
          }
        },
        debug: function() {
          if(!settings.silent && settings.debug) {
            if(settings.performance) {
              module.performance.log(arguments);
            }
            else {
              module.debug = Function.prototype.bind.call(console.info, console, settings.name + ':');
              module.debug.apply(console, arguments);
            }
          }
        },
        verbose: function() {
          if(!settings.silent && settings.verbose && settings.debug) {
            if(settings.performance) {
              module.performance.log(arguments);
            }
            else {
              module.verbose = Function.prototype.bind.call(console.info, console, settings.name + ':');
              module.verbose.apply(console, arguments);
            }
          }
        },
        error: function() {
          if(!settings.silent) {
            module.error = Function.prototype.bind.call(console.error, console, settings.name + ':');
            module.error.apply(console, arguments);
          }
        },
        performance: {
          log: function(message) {
            var
              currentTime,
              executionTime,
              previousTime
            ;
            if(settings.performance) {
              currentTime   = new Date().getTime();
              previousTime  = time || currentTime;
              executionTime = currentTime - previousTime;
              time          = currentTime;
              performance.push({
                'Name'           : message[0],
                'Arguments'      : [].slice.call(message, 1) || '',
                'Element'        : element,
                'Execution Time' : executionTime
              });
            }
            clearTimeout(module.performance.timer);
            module.performance.timer = setTimeout(module.performance.display, 500);
          },
          display: function() {
            var
              title = settings.name + ':',
              totalTime = 0
            ;
            time = false;
            clearTimeout(module.performance.timer);
            $.each(performance, function(index, data) {
              totalTime += data['Execution Time'];
            });
            title += ' ' + totalTime + 'ms';
            if(moduleSelector) {
              title += ' \'' + moduleSelector + '\'';
            }
            if( (console.group !== undefined || console.table !== undefined) && performance.length > 0) {
              console.groupCollapsed(title);
              if(console.table) {
                console.table(performance);
              }
              else {
                $.each(performance, function(index, data) {
                  console.log(data['Name'] + ': ' + data['Execution Time']+'ms');
                });
              }
              console.groupEnd();
            }
            performance = [];
          }
        },
        invoke: function(query, passedArguments, context) {
          var
            object = instance,
            maxDepth,
            found,
            response
          ;
          passedArguments = passedArguments || queryArguments;
          context         = element         || context;
          if(typeof query == 'string' && object !== undefined) {
            query    = query.split(/[\. ]/);
            maxDepth = query.length - 1;
            $.each(query, function(depth, value) {
              var camelCaseValue = (depth != maxDepth)
                ? value + query[depth + 1].charAt(0).toUpperCase() + query[depth + 1].slice(1)
                : query
              ;
              if( $.isPlainObject( object[camelCaseValue] ) && (depth != maxDepth) ) {
                object = object[camelCaseValue];
              }
              else if( object[camelCaseValue] !== undefined ) {
                found = object[camelCaseValue];
                return false;
              }
              else if( $.isPlainObject( object[value] ) && (depth != maxDepth) ) {
                object = object[value];
              }
              else if( object[value] !== undefined ) {
                found = object[value];
                return false;
              }
              else {
                return false;
              }
            });
          }
          if ( $.isFunction( found ) ) {
            response = found.apply(context, passedArguments);
          }
          else if(found !== undefined) {
            response = found;
          }
          if($.isArray(returnedValue)) {
            returnedValue.push(response);
          }
          else if(returnedValue !== undefined) {
            returnedValue = [returnedValue, response];
          }
          else if(response !== undefined) {
            returnedValue = response;
          }
          return found;
        }
      };

      if(methodInvoked) {
        if(instance === undefined) {
          module.initialize();
        }
        module.invoke(query);
      }
      else {
        if(instance !== undefined) {
          instance.invoke('destroy');
        }
        module.initialize();
      }
    })
  ;

  return (returnedValue !== undefined)
    ? returnedValue
    : this
  ;
};

$.fn.modal.settings = {

  name           : 'Modal',
  namespace      : 'modal',

  useFlex        : 'auto',
  offset         : 0,

  silent         : false,
  debug          : false,
  verbose        : false,
  performance    : true,

  observeChanges : false,

  allowMultiple  : false,
  detachable     : true,
  closable       : true,
  autofocus      : true,

  inverted       : false,
  blurring       : false,

  centered       : true,

  dimmerSettings : {
    closable : false,
    useCSS   : true
  },

  // whether to use keyboard shortcuts
  keyboardShortcuts: true,

  context    : 'body',

  queue      : false,
  duration   : 500,
  transition : 'scale',

  // padding with edge of page
  padding    : 50,

  // called before show animation
  onShow     : function(){},

  // called after show animation
  onVisible  : function(){},

  // called before hide animation
  onHide     : function(){ return true; },

  // called after hide animation
  onHidden   : function(){},

  // called after approve selector match
  onApprove  : function(){ return true; },

  // called after deny selector match
  onDeny     : function(){ return true; },

  selector    : {
    close    : '> .close',
    approve  : '.actions .positive, .actions .approve, .actions .ok',
    deny     : '.actions .negative, .actions .deny, .actions .cancel',
    modal    : '.ui.modal'
  },
  error : {
    dimmer    : 'UI Dimmer, a required component is not included in this page',
    method    : 'The method you called is not defined.',
    notFound  : 'The element you specified could not be found'
  },
  className : {
    active     : 'active',
    animating  : 'animating',
    blurring   : 'blurring',
    inverted   : 'inverted',
    legacy     : 'legacy',
    loading    : 'loading',
    scrolling  : 'scrolling',
    undetached : 'undetached'
  }
};


})( jQuery, window, document );

/*!
 * # Semantic UI 2.4.2 - Popup
 * http://github.com/semantic-org/semantic-ui/
 *
 *
 * Released under the MIT license
 * http://opensource.org/licenses/MIT
 *
 */

;(function ($, window, document, undefined) {

'use strict';

window = (typeof window != 'undefined' && window.Math == Math)
  ? window
  : (typeof self != 'undefined' && self.Math == Math)
    ? self
    : Function('return this')()
;

$.fn.popup = function(parameters) {
  var
    $allModules    = $(this),
    $document      = $(document),
    $window        = $(window),
    $body          = $('body'),

    moduleSelector = $allModules.selector || '',

    hasTouch       = (true),
    time           = new Date().getTime(),
    performance    = [],

    query          = arguments[0],
    methodInvoked  = (typeof query == 'string'),
    queryArguments = [].slice.call(arguments, 1),

    returnedValue
  ;
  $allModules
    .each(function() {
      var
        settings        = ( $.isPlainObject(parameters) )
          ? $.extend(true, {}, $.fn.popup.settings, parameters)
          : $.extend({}, $.fn.popup.settings),

        selector           = settings.selector,
        className          = settings.className,
        error              = settings.error,
        metadata           = settings.metadata,
        namespace          = settings.namespace,

        eventNamespace     = '.' + settings.namespace,
        moduleNamespace    = 'module-' + namespace,

        $module            = $(this),
        $context           = $(settings.context),
        $scrollContext     = $(settings.scrollContext),
        $boundary          = $(settings.boundary),
        $target            = (settings.target)
          ? $(settings.target)
          : $module,

        $popup,
        $offsetParent,

        searchDepth        = 0,
        triedPositions     = false,
        openedWithTouch    = false,

        element            = this,
        instance           = $module.data(moduleNamespace),

        documentObserver,
        elementNamespace,
        id,
        module
      ;

      module = {

        // binds events
        initialize: function() {
          module.debug('Initializing', $module);
          module.createID();
          module.bind.events();
          if(!module.exists() && settings.preserve) {
            module.create();
          }
          if(settings.observeChanges) {
            module.observeChanges();
          }
          module.instantiate();
        },

        instantiate: function() {
          module.verbose('Storing instance', module);
          instance = module;
          $module
            .data(moduleNamespace, instance)
          ;
        },

        observeChanges: function() {
          if('MutationObserver' in window) {
            documentObserver = new MutationObserver(module.event.documentChanged);
            documentObserver.observe(document, {
              childList : true,
              subtree   : true
            });
            module.debug('Setting up mutation observer', documentObserver);
          }
        },

        refresh: function() {
          if(settings.popup) {
            $popup = $(settings.popup).eq(0);
          }
          else {
            if(settings.inline) {
              $popup = $target.nextAll(selector.popup).eq(0);
              settings.popup = $popup;
            }
          }
          if(settings.popup) {
            $popup.addClass(className.loading);
            $offsetParent = module.get.offsetParent();
            $popup.removeClass(className.loading);
            if(settings.movePopup && module.has.popup() && module.get.offsetParent($popup)[0] !== $offsetParent[0]) {
              module.debug('Moving popup to the same offset parent as target');
              $popup
                .detach()
                .appendTo($offsetParent)
              ;
            }
          }
          else {
            $offsetParent = (settings.inline)
              ? module.get.offsetParent($target)
              : module.has.popup()
                ? module.get.offsetParent($popup)
                : $body
            ;
          }
          if( $offsetParent.is('html') && $offsetParent[0] !== $body[0] ) {
            module.debug('Setting page as offset parent');
            $offsetParent = $body;
          }
          if( module.get.variation() ) {
            module.set.variation();
          }
        },

        reposition: function() {
          module.refresh();
          module.set.position();
        },

        destroy: function() {
          module.debug('Destroying previous module');
          if(documentObserver) {
            documentObserver.disconnect();
          }
          // remove element only if was created dynamically
          if($popup && !settings.preserve) {
            module.removePopup();
          }
          // clear all timeouts
          clearTimeout(module.hideTimer);
          clearTimeout(module.showTimer);
          // remove events
          module.unbind.close();
          module.unbind.events();
          $module
            .removeData(moduleNamespace)
          ;
        },

        event: {
          start:  function(event) {
            var
              delay = ($.isPlainObject(settings.delay))
                ? settings.delay.show
                : settings.delay
            ;
            clearTimeout(module.hideTimer);
            if(!openedWithTouch) {
              module.showTimer = setTimeout(module.show, delay);
            }
          },
          end:  function() {
            var
              delay = ($.isPlainObject(settings.delay))
                ? settings.delay.hide
                : settings.delay
            ;
            clearTimeout(module.showTimer);
            module.hideTimer = setTimeout(module.hide, delay);
          },
          touchstart: function(event) {
            openedWithTouch = true;
            module.show();
          },
          resize: function() {
            if( module.is.visible() ) {
              module.set.position();
            }
          },
          documentChanged: function(mutations) {
            [].forEach.call(mutations, function(mutation) {
              if(mutation.removedNodes) {
                [].forEach.call(mutation.removedNodes, function(node) {
                  if(node == element || $(node).find(element).length > 0) {
                    module.debug('Element removed from DOM, tearing down events');
                    module.destroy();
                  }
                });
              }
            });
          },
          hideGracefully: function(event) {
            var
              $target = $(event.target),
              isInDOM = $.contains(document.documentElement, event.target),
              inPopup = ($target.closest(selector.popup).length > 0)
            ;
            // don't close on clicks inside popup
            if(event && !inPopup && isInDOM) {
              module.debug('Click occurred outside popup hiding popup');
              module.hide();
            }
            else {
              module.debug('Click was inside popup, keeping popup open');
            }
          }
        },

        // generates popup html from metadata
        create: function() {
          var
            html      = module.get.html(),
            title     = module.get.title(),
            content   = module.get.content()
          ;

          if(html || content || title) {
            module.debug('Creating pop-up html');
            if(!html) {
              html = settings.templates.popup({
                title   : title,
                content : content
              });
            }
            $popup = $('<div/>')
              .addClass(className.popup)
              .data(metadata.activator, $module)
              .html(html)
            ;
            if(settings.inline) {
              module.verbose('Inserting popup element inline', $popup);
              $popup
                .insertAfter($module)
              ;
            }
            else {
              module.verbose('Appending popup element to body', $popup);
              $popup
                .appendTo( $context )
              ;
            }
            module.refresh();
            module.set.variation();

            if(settings.hoverable) {
              module.bind.popup();
            }
            settings.onCreate.call($popup, element);
          }
          else if($target.next(selector.popup).length !== 0) {
            module.verbose('Pre-existing popup found');
            settings.inline = true;
            settings.popup  = $target.next(selector.popup).data(metadata.activator, $module);
            module.refresh();
            if(settings.hoverable) {
              module.bind.popup();
            }
          }
          else if(settings.popup) {
            $(settings.popup).data(metadata.activator, $module);
            module.verbose('Used popup specified in settings');
            module.refresh();
            if(settings.hoverable) {
              module.bind.popup();
            }
          }
          else {
            module.debug('No content specified skipping display', element);
          }
        },

        createID: function() {
          id = (Math.random().toString(16) + '000000000').substr(2, 8);
          elementNamespace = '.' + id;
          module.verbose('Creating unique id for element', id);
        },

        // determines popup state
        toggle: function() {
          module.debug('Toggling pop-up');
          if( module.is.hidden() ) {
            module.debug('Popup is hidden, showing pop-up');
            module.unbind.close();
            module.show();
          }
          else {
            module.debug('Popup is visible, hiding pop-up');
            module.hide();
          }
        },

        show: function(callback) {
          callback = callback || function(){};
          module.debug('Showing pop-up', settings.transition);
          if(module.is.hidden() && !( module.is.active() && module.is.dropdown()) ) {
            if( !module.exists() ) {
              module.create();
            }
            if(settings.onShow.call($popup, element) === false) {
              module.debug('onShow callback returned false, cancelling popup animation');
              return;
            }
            else if(!settings.preserve && !settings.popup) {
              module.refresh();
            }
            if( $popup && module.set.position() ) {
              module.save.conditions();
              if(settings.exclusive) {
                module.hideAll();
              }
              module.animate.show(callback);
            }
          }
        },


        hide: function(callback) {
          callback = callback || function(){};
          if( module.is.visible() || module.is.animating() ) {
            if(settings.onHide.call($popup, element) === false) {
              module.debug('onHide callback returned false, cancelling popup animation');
              return;
            }
            module.remove.visible();
            module.unbind.close();
            module.restore.conditions();
            module.animate.hide(callback);
          }
        },

        hideAll: function() {
          $(selector.popup)
            .filter('.' + className.popupVisible)
            .each(function() {
              $(this)
                .data(metadata.activator)
                  .popup('hide')
              ;
            })
          ;
        },
        exists: function() {
          if(!$popup) {
            return false;
          }
          if(settings.inline || settings.popup) {
            return ( module.has.popup() );
          }
          else {
            return ( $popup.closest($context).length >= 1 )
              ? true
              : false
            ;
          }
        },

        removePopup: function() {
          if( module.has.popup() && !settings.popup) {
            module.debug('Removing popup', $popup);
            $popup.remove();
            $popup = undefined;
            settings.onRemove.call($popup, element);
          }
        },

        save: {
          conditions: function() {
            module.cache = {
              title: $module.attr('title')
            };
            if (module.cache.title) {
              $module.removeAttr('title');
            }
            module.verbose('Saving original attributes', module.cache.title);
          }
        },
        restore: {
          conditions: function() {
            if(module.cache && module.cache.title) {
              $module.attr('title', module.cache.title);
              module.verbose('Restoring original attributes', module.cache.title);
            }
            return true;
          }
        },
        supports: {
          svg: function() {
            return (typeof SVGGraphicsElement === 'undefined');
          }
        },
        animate: {
          show: function(callback) {
            callback = $.isFunction(callback) ? callback : function(){};
            if(settings.transition && $.fn.transition !== undefined && $module.transition('is supported')) {
              module.set.visible();
              $popup
                .transition({
                  animation  : settings.transition + ' in',
                  queue      : false,
                  debug      : settings.debug,
                  verbose    : settings.verbose,
                  duration   : settings.duration,
                  onComplete : function() {
                    module.bind.close();
                    callback.call($popup, element);
                    settings.onVisible.call($popup, element);
                  }
                })
              ;
            }
            else {
              module.error(error.noTransition);
            }
          },
          hide: function(callback) {
            callback = $.isFunction(callback) ? callback : function(){};
            module.debug('Hiding pop-up');
            if(settings.onHide.call($popup, element) === false) {
              module.debug('onHide callback returned false, cancelling popup animation');
              return;
            }
            if(settings.transition && $.fn.transition !== undefined && $module.transition('is supported')) {
              $popup
                .transition({
                  animation  : settings.transition + ' out',
                  queue      : false,
                  duration   : settings.duration,
                  debug      : settings.debug,
                  verbose    : settings.verbose,
                  onComplete : function() {
                    module.reset();
                    callback.call($popup, element);
                    settings.onHidden.call($popup, element);
                  }
                })
              ;
            }
            else {
              module.error(error.noTransition);
            }
          }
        },

        change: {
          content: function(html) {
            $popup.html(html);
          }
        },

        get: {
          html: function() {
            $module.removeData(metadata.html);
            return $module.data(metadata.html) || settings.html;
          },
          title: function() {
            $module.removeData(metadata.title);
            return $module.data(metadata.title) || settings.title;
          },
          content: function() {
            $module.removeData(metadata.content);
            return $module.data(metadata.content) || settings.content || $module.attr('title');
          },
          variation: function() {
            $module.removeData(metadata.variation);
            return $module.data(metadata.variation) || settings.variation;
          },
          popup: function() {
            return $popup;
          },
          popupOffset: function() {
            return $popup.offset();
          },
          calculations: function() {
            var
              $popupOffsetParent = module.get.offsetParent($popup),
              targetElement      = $target[0],
              isWindow           = ($boundary[0] == window),
              targetPosition     = (settings.inline || (settings.popup && settings.movePopup))
                ? $target.position()
                : $target.offset(),
              screenPosition = (isWindow)
                ? { top: 0, left: 0 }
                : $boundary.offset(),
              calculations   = {},
              scroll = (isWindow)
                ? { top: $window.scrollTop(), left: $window.scrollLeft() }
                : { top: 0, left: 0},
              screen
            ;
            calculations = {
              // element which is launching popup
              target : {
                element : $target[0],
                width   : $target.outerWidth(),
                height  : $target.outerHeight(),
                top     : targetPosition.top,
                left    : targetPosition.left,
                margin  : {}
              },
              // popup itself
              popup : {
                width  : $popup.outerWidth(),
                height : $popup.outerHeight()
              },
              // offset container (or 3d context)
              parent : {
                width  : $offsetParent.outerWidth(),
                height : $offsetParent.outerHeight()
              },
              // screen boundaries
              screen : {
                top  : screenPosition.top,
                left : screenPosition.left,
                scroll: {
                  top  : scroll.top,
                  left : scroll.left
                },
                width  : $boundary.width(),
                height : $boundary.height()
              }
            };

            // if popup offset context is not same as target, then adjust calculations
            if($popupOffsetParent.get(0) !== $offsetParent.get(0)) {
              var
                popupOffset        = $popupOffsetParent.offset()
              ;
              calculations.target.top -= popupOffset.top;
              calculations.target.left -= popupOffset.left;
              calculations.parent.width = $popupOffsetParent.outerWidth();
              calculations.parent.height = $popupOffsetParent.outerHeight();
            }

            // add in container calcs if fluid
            if( settings.setFluidWidth && module.is.fluid() ) {
              calculations.container = {
                width: $popup.parent().outerWidth()
              };
              calculations.popup.width = calculations.container.width;
            }

            // add in margins if inline
            calculations.target.margin.top = (settings.inline)
              ? parseInt( window.getComputedStyle(targetElement).getPropertyValue('margin-top'), 10)
              : 0
            ;
            calculations.target.margin.left = (settings.inline)
              ? module.is.rtl()
                ? parseInt( window.getComputedStyle(targetElement).getPropertyValue('margin-right'), 10)
                : parseInt( window.getComputedStyle(targetElement).getPropertyValue('margin-left'), 10)
              : 0
            ;
            // calculate screen boundaries
            screen = calculations.screen;
            calculations.boundary = {
              top    : screen.top + screen.scroll.top,
              bottom : screen.top + screen.scroll.top + screen.height,
              left   : screen.left + screen.scroll.left,
              right  : screen.left + screen.scroll.left + screen.width
            };
            return calculations;
          },
          id: function() {
            return id;
          },
          startEvent: function() {
            if(settings.on == 'hover') {
              return 'mouseenter';
            }
            else if(settings.on == 'focus') {
              return 'focus';
            }
            return false;
          },
          scrollEvent: function() {
            return 'scroll';
          },
          endEvent: function() {
            if(settings.on == 'hover') {
              return 'mouseleave';
            }
            else if(settings.on == 'focus') {
              return 'blur';
            }
            return false;
          },
          distanceFromBoundary: function(offset, calculations) {
            var
              distanceFromBoundary = {},
              popup,
              boundary
            ;
            calculations = calculations || module.get.calculations();

            // shorthand
            popup        = calculations.popup;
            boundary     = calculations.boundary;

            if(offset) {
              distanceFromBoundary = {
                top    : (offset.top - boundary.top),
                left   : (offset.left - boundary.left),
                right  : (boundary.right - (offset.left + popup.width) ),
                bottom : (boundary.bottom - (offset.top + popup.height) )
              };
              module.verbose('Distance from boundaries determined', offset, distanceFromBoundary);
            }
            return distanceFromBoundary;
          },
          offsetParent: function($element) {
            var
              element = ($element !== undefined)
                ? $element[0]
                : $target[0],
              parentNode = element.parentNode,
              $node    = $(parentNode)
            ;
            if(parentNode) {
              var
                is2D     = ($node.css('transform') === 'none'),
                isStatic = ($node.css('position') === 'static'),
                isBody   = $node.is('body')
              ;
              while(parentNode && !isBody && isStatic && is2D) {
                parentNode = parentNode.parentNode;
                $node    = $(parentNode);
                is2D     = ($node.css('transform') === 'none');
                isStatic = ($node.css('position') === 'static');
                isBody   = $node.is('body');
              }
            }
            return ($node && $node.length > 0)
              ? $node
              : $()
            ;
          },
          positions: function() {
            return {
              'top left'      : false,
              'top center'    : false,
              'top right'     : false,
              'bottom left'   : false,
              'bottom center' : false,
              'bottom right'  : false,
              'left center'   : false,
              'right center'  : false
            };
          },
          nextPosition: function(position) {
            var
              positions          = position.split(' '),
              verticalPosition   = positions[0],
              horizontalPosition = positions[1],
              opposite = {
                top    : 'bottom',
                bottom : 'top',
                left   : 'right',
                right  : 'left'
              },
              adjacent = {
                left   : 'center',
                center : 'right',
                right  : 'left'
              },
              backup = {
                'top left'      : 'top center',
                'top center'    : 'top right',
                'top right'     : 'right center',
                'right center'  : 'bottom right',
                'bottom right'  : 'bottom center',
                'bottom center' : 'bottom left',
                'bottom left'   : 'left center',
                'left center'   : 'top left'
              },
              adjacentsAvailable = (verticalPosition == 'top' || verticalPosition == 'bottom'),
              oppositeTried = false,
              adjacentTried = false,
              nextPosition  = false
            ;
            if(!triedPositions) {
              module.verbose('All available positions available');
              triedPositions = module.get.positions();
            }

            module.debug('Recording last position tried', position);
            triedPositions[position] = true;

            if(settings.prefer === 'opposite') {
              nextPosition  = [opposite[verticalPosition], horizontalPosition];
              nextPosition  = nextPosition.join(' ');
              oppositeTried = (triedPositions[nextPosition] === true);
              module.debug('Trying opposite strategy', nextPosition);
            }
            if((settings.prefer === 'adjacent') && adjacentsAvailable ) {
              nextPosition  = [verticalPosition, adjacent[horizontalPosition]];
              nextPosition  = nextPosition.join(' ');
              adjacentTried = (triedPositions[nextPosition] === true);
              module.debug('Trying adjacent strategy', nextPosition);
            }
            if(adjacentTried || oppositeTried) {
              module.debug('Using backup position', nextPosition);
              nextPosition = backup[position];
            }
            return nextPosition;
          }
        },

        set: {
          position: function(position, calculations) {

            // exit conditions
            if($target.length === 0 || $popup.length === 0) {
              module.error(error.notFound);
              return;
            }
            var
              offset,
              distanceAway,
              target,
              popup,
              parent,
              positioning,
              popupOffset,
              distanceFromBoundary
            ;

            calculations = calculations || module.get.calculations();
            position     = position     || $module.data(metadata.position) || settings.position;

            offset       = $module.data(metadata.offset) || settings.offset;
            distanceAway = settings.distanceAway;

            // shorthand
            target = calculations.target;
            popup  = calculations.popup;
            parent = calculations.parent;

            if(module.should.centerArrow(calculations)) {
              module.verbose('Adjusting offset to center arrow on small target element');
              if(position == 'top left' || position == 'bottom left') {
                offset += (target.width / 2)
                offset -= settings.arrowPixelsFromEdge;
              }
              if(position == 'top right' || position == 'bottom right') {
                offset -= (target.width / 2)
                offset += settings.arrowPixelsFromEdge;
              }
            }

            if(target.width === 0 && target.height === 0 && !module.is.svg(target.element)) {
              module.debug('Popup target is hidden, no action taken');
              return false;
            }

            if(settings.inline) {
              module.debug('Adding margin to calculation', target.margin);
              if(position == 'left center' || position == 'right center') {
                offset       +=  target.margin.top;
                distanceAway += -target.margin.left;
              }
              else if (position == 'top left' || position == 'top center' || position == 'top right') {
                offset       += target.margin.left;
                distanceAway -= target.margin.top;
              }
              else {
                offset       += target.margin.left;
                distanceAway += target.margin.top;
              }
            }

            module.debug('Determining popup position from calculations', position, calculations);

            if (module.is.rtl()) {
              position = position.replace(/left|right/g, function (match) {
                return (match == 'left')
                  ? 'right'
                  : 'left'
                ;
              });
              module.debug('RTL: Popup position updated', position);
            }

            // if last attempt use specified last resort position
            if(searchDepth == settings.maxSearchDepth && typeof settings.lastResort === 'string') {
              position = settings.lastResort;
            }

            switch (position) {
              case 'top left':
                positioning = {
                  top    : 'auto',
                  bottom : parent.height - target.top + distanceAway,
                  left   : target.left + offset,
                  right  : 'auto'
                };
              break;
              case 'top center':
                positioning = {
                  bottom : parent.height - target.top + distanceAway,
                  left   : target.left + (target.width / 2) - (popup.width / 2) + offset,
                  top    : 'auto',
                  right  : 'auto'
                };
              break;
              case 'top right':
                positioning = {
                  bottom :  parent.height - target.top + distanceAway,
                  right  :  parent.width - target.left - target.width - offset,
                  top    : 'auto',
                  left   : 'auto'
                };
              break;
              case 'left center':
                positioning = {
                  top    : target.top + (target.height / 2) - (popup.height / 2) + offset,
                  right  : parent.width - target.left + distanceAway,
                  left   : 'auto',
                  bottom : 'auto'
                };
              break;
              case 'right center':
                positioning = {
                  top    : target.top + (target.height / 2) - (popup.height / 2) + offset,
                  left   : target.left + target.width + distanceAway,
                  bottom : 'auto',
                  right  : 'auto'
                };
              break;
              case 'bottom left':
                positioning = {
                  top    : target.top + target.height + distanceAway,
                  left   : target.left + offset,
                  bottom : 'auto',
                  right  : 'auto'
                };
              break;
              case 'bottom center':
                positioning = {
                  top    : target.top + target.height + distanceAway,
                  left   : target.left + (target.width / 2) - (popup.width / 2) + offset,
                  bottom : 'auto',
                  right  : 'auto'
                };
              break;
              case 'bottom right':
                positioning = {
                  top    : target.top + target.height + distanceAway,
                  right  : parent.width - target.left  - target.width - offset,
                  left   : 'auto',
                  bottom : 'auto'
                };
              break;
            }
            if(positioning === undefined) {
              module.error(error.invalidPosition, position);
            }

            module.debug('Calculated popup positioning values', positioning);

            // tentatively place on stage
            $popup
              .css(positioning)
              .removeClass(className.position)
              .addClass(position)
              .addClass(className.loading)
            ;

            popupOffset = module.get.popupOffset();

            // see if any boundaries are surpassed with this tentative position
            distanceFromBoundary = module.get.distanceFromBoundary(popupOffset, calculations);

            if( module.is.offstage(distanceFromBoundary, position) ) {
              module.debug('Position is outside viewport', position);
              if(searchDepth < settings.maxSearchDepth) {
                searchDepth++;
                position = module.get.nextPosition(position);
                module.debug('Trying new position', position);
                return ($popup)
                  ? module.set.position(position, calculations)
                  : false
                ;
              }
              else {
                if(settings.lastResort) {
                  module.debug('No position found, showing with last position');
                }
                else {
                  module.debug('Popup could not find a position to display', $popup);
                  module.error(error.cannotPlace, element);
                  module.remove.attempts();
                  module.remove.loading();
                  module.reset();
                  settings.onUnplaceable.call($popup, element);
                  return false;
                }
              }
            }
            module.debug('Position is on stage', position);
            module.remove.attempts();
            module.remove.loading();
            if( settings.setFluidWidth && module.is.fluid() ) {
              module.set.fluidWidth(calculations);
            }
            return true;
          },

          fluidWidth: function(calculations) {
            calculations = calculations || module.get.calculations();
            module.debug('Automatically setting element width to parent width', calculations.parent.width);
            $popup.css('width', calculations.container.width);
          },

          variation: function(variation) {
            variation = variation || module.get.variation();
            if(variation && module.has.popup() ) {
              module.verbose('Adding variation to popup', variation);
              $popup.addClass(variation);
            }
          },

          visible: function() {
            $module.addClass(className.visible);
          }
        },

        remove: {
          loading: function() {
            $popup.removeClass(className.loading);
          },
          variation: function(variation) {
            variation = variation || module.get.variation();
            if(variation) {
              module.verbose('Removing variation', variation);
              $popup.removeClass(variation);
            }
          },
          visible: function() {
            $module.removeClass(className.visible);
          },
          attempts: function() {
            module.verbose('Resetting all searched positions');
            searchDepth    = 0;
            triedPositions = false;
          }
        },

        bind: {
          events: function() {
            module.debug('Binding popup events to module');
            if(settings.on == 'click') {
              $module
                .on('click' + eventNamespace, module.toggle)
              ;
            }
            if(settings.on == 'hover' && hasTouch) {
              $module
                .on('touchstart' + eventNamespace, module.event.touchstart)
              ;
            }
            if( module.get.startEvent() ) {
              $module
                .on(module.get.startEvent() + eventNamespace, module.event.start)
                .on(module.get.endEvent() + eventNamespace, module.event.end)
              ;
            }
            if(settings.target) {
              module.debug('Target set to element', $target);
            }
            $window.on('resize' + elementNamespace, module.event.resize);
          },
          popup: function() {
            module.verbose('Allowing hover events on popup to prevent closing');
            if( $popup && module.has.popup() ) {
              $popup
                .on('mouseenter' + eventNamespace, module.event.start)
                .on('mouseleave' + eventNamespace, module.event.end)
              ;
            }
          },
          close: function() {
            if(settings.hideOnScroll === true || (settings.hideOnScroll == 'auto' && settings.on != 'click')) {
              module.bind.closeOnScroll();
            }
            if(module.is.closable()) {
              module.bind.clickaway();
            }
            else if(settings.on == 'hover' && openedWithTouch) {
              module.bind.touchClose();
            }
          },
          closeOnScroll: function() {
            module.verbose('Binding scroll close event to document');
            $scrollContext
              .one(module.get.scrollEvent() + elementNamespace, module.event.hideGracefully)
            ;
          },
          touchClose: function() {
            module.verbose('Binding popup touchclose event to document');
            $document
              .on('touchstart' + elementNamespace, function(event) {
                module.verbose('Touched away from popup');
                module.event.hideGracefully.call(element, event);
              })
            ;
          },
          clickaway: function() {
            module.verbose('Binding popup close event to document');
            $document
              .on('click' + elementNamespace, function(event) {
                module.verbose('Clicked away from popup');
                module.event.hideGracefully.call(element, event);
              })
            ;
          }
        },

        unbind: {
          events: function() {
            $window
              .off(elementNamespace)
            ;
            $module
              .off(eventNamespace)
            ;
          },
          close: function() {
            $document
              .off(elementNamespace)
            ;
            $scrollContext
              .off(elementNamespace)
            ;
          },
        },

        has: {
          popup: function() {
            return ($popup && $popup.length > 0);
          }
        },

        should: {
          centerArrow: function(calculations) {
            return !module.is.basic() && calculations.target.width <= (settings.arrowPixelsFromEdge * 2);
          },
        },

        is: {
          closable: function() {
            if(settings.closable == 'auto') {
              if(settings.on == 'hover') {
                return false;
              }
              return true;
            }
            return settings.closable;
          },
          offstage: function(distanceFromBoundary, position) {
            var
              offstage = []
            ;
            // return boundaries that have been surpassed
            $.each(distanceFromBoundary, function(direction, distance) {
              if(distance < -settings.jitter) {
                module.debug('Position exceeds allowable distance from edge', direction, distance, position);
                offstage.push(direction);
              }
            });
            if(offstage.length > 0) {
              return true;
            }
            else {
              return false;
            }
          },
          svg: function(element) {
            return module.supports.svg() && (element instanceof SVGGraphicsElement);
          },
          basic: function() {
            return $module.hasClass(className.basic);
          },
          active: function() {
            return $module.hasClass(className.active);
          },
          animating: function() {
            return ($popup !== undefined && $popup.hasClass(className.animating) );
          },
          fluid: function() {
            return ($popup !== undefined && $popup.hasClass(className.fluid));
          },
          visible: function() {
            return ($popup !== undefined && $popup.hasClass(className.popupVisible));
          },
          dropdown: function() {
            return $module.hasClass(className.dropdown);
          },
          hidden: function() {
            return !module.is.visible();
          },
          rtl: function () {
            return $module.css('direction') == 'rtl';
          }
        },

        reset: function() {
          module.remove.visible();
          if(settings.preserve) {
            if($.fn.transition !== undefined) {
              $popup
                .transition('remove transition')
              ;
            }
          }
          else {
            module.removePopup();
          }
        },

        setting: function(name, value) {
          if( $.isPlainObject(name) ) {
            $.extend(true, settings, name);
          }
          else if(value !== undefined) {
            settings[name] = value;
          }
          else {
            return settings[name];
          }
        },
        internal: function(name, value) {
          if( $.isPlainObject(name) ) {
            $.extend(true, module, name);
          }
          else if(value !== undefined) {
            module[name] = value;
          }
          else {
            return module[name];
          }
        },
        debug: function() {
          if(!settings.silent && settings.debug) {
            if(settings.performance) {
              module.performance.log(arguments);
            }
            else {
              module.debug = Function.prototype.bind.call(console.info, console, settings.name + ':');
              module.debug.apply(console, arguments);
            }
          }
        },
        verbose: function() {
          if(!settings.silent && settings.verbose && settings.debug) {
            if(settings.performance) {
              module.performance.log(arguments);
            }
            else {
              module.verbose = Function.prototype.bind.call(console.info, console, settings.name + ':');
              module.verbose.apply(console, arguments);
            }
          }
        },
        error: function() {
          if(!settings.silent) {
            module.error = Function.prototype.bind.call(console.error, console, settings.name + ':');
            module.error.apply(console, arguments);
          }
        },
        performance: {
          log: function(message) {
            var
              currentTime,
              executionTime,
              previousTime
            ;
            if(settings.performance) {
              currentTime   = new Date().getTime();
              previousTime  = time || currentTime;
              executionTime = currentTime - previousTime;
              time          = currentTime;
              performance.push({
                'Name'           : message[0],
                'Arguments'      : [].slice.call(message, 1) || '',
                'Element'        : element,
                'Execution Time' : executionTime
              });
            }
            clearTimeout(module.performance.timer);
            module.performance.timer = setTimeout(module.performance.display, 500);
          },
          display: function() {
            var
              title = settings.name + ':',
              totalTime = 0
            ;
            time = false;
            clearTimeout(module.performance.timer);
            $.each(performance, function(index, data) {
              totalTime += data['Execution Time'];
            });
            title += ' ' + totalTime + 'ms';
            if(moduleSelector) {
              title += ' \'' + moduleSelector + '\'';
            }
            if( (console.group !== undefined || console.table !== undefined) && performance.length > 0) {
              console.groupCollapsed(title);
              if(console.table) {
                console.table(performance);
              }
              else {
                $.each(performance, function(index, data) {
                  console.log(data['Name'] + ': ' + data['Execution Time']+'ms');
                });
              }
              console.groupEnd();
            }
            performance = [];
          }
        },
        invoke: function(query, passedArguments, context) {
          var
            object = instance,
            maxDepth,
            found,
            response
          ;
          passedArguments = passedArguments || queryArguments;
          context         = element         || context;
          if(typeof query == 'string' && object !== undefined) {
            query    = query.split(/[\. ]/);
            maxDepth = query.length - 1;
            $.each(query, function(depth, value) {
              var camelCaseValue = (depth != maxDepth)
                ? value + query[depth + 1].charAt(0).toUpperCase() + query[depth + 1].slice(1)
                : query
              ;
              if( $.isPlainObject( object[camelCaseValue] ) && (depth != maxDepth) ) {
                object = object[camelCaseValue];
              }
              else if( object[camelCaseValue] !== undefined ) {
                found = object[camelCaseValue];
                return false;
              }
              else if( $.isPlainObject( object[value] ) && (depth != maxDepth) ) {
                object = object[value];
              }
              else if( object[value] !== undefined ) {
                found = object[value];
                return false;
              }
              else {
                return false;
              }
            });
          }
          if ( $.isFunction( found ) ) {
            response = found.apply(context, passedArguments);
          }
          else if(found !== undefined) {
            response = found;
          }
          if($.isArray(returnedValue)) {
            returnedValue.push(response);
          }
          else if(returnedValue !== undefined) {
            returnedValue = [returnedValue, response];
          }
          else if(response !== undefined) {
            returnedValue = response;
          }
          return found;
        }
      };

      if(methodInvoked) {
        if(instance === undefined) {
          module.initialize();
        }
        module.invoke(query);
      }
      else {
        if(instance !== undefined) {
          instance.invoke('destroy');
        }
        module.initialize();
      }
    })
  ;

  return (returnedValue !== undefined)
    ? returnedValue
    : this
  ;
};

$.fn.popup.settings = {

  name           : 'Popup',

  // module settings
  silent         : false,
  debug          : false,
  verbose        : false,
  performance    : true,
  namespace      : 'popup',

  // whether it should use dom mutation observers
  observeChanges : true,

  // callback only when element added to dom
  onCreate       : function(){},

  // callback before element removed from dom
  onRemove       : function(){},

  // callback before show animation
  onShow         : function(){},

  // callback after show animation
  onVisible      : function(){},

  // callback before hide animation
  onHide         : function(){},

  // callback when popup cannot be positioned in visible screen
  onUnplaceable  : function(){},

  // callback after hide animation
  onHidden       : function(){},

  // when to show popup
  on             : 'hover',

  // element to use to determine if popup is out of boundary
  boundary       : window,

  // whether to add touchstart events when using hover
  addTouchEvents : true,

  // default position relative to element
  position       : 'top left',

  // name of variation to use
  variation      : '',

  // whether popup should be moved to context
  movePopup      : true,

  // element which popup should be relative to
  target         : false,

  // jq selector or element that should be used as popup
  popup          : false,

  // popup should remain inline next to activator
  inline         : false,

  // popup should be removed from page on hide
  preserve       : false,

  // popup should not close when being hovered on
  hoverable      : false,

  // explicitly set content
  content        : false,

  // explicitly set html
  html           : false,

  // explicitly set title
  title          : false,

  // whether automatically close on clickaway when on click
  closable       : true,

  // automatically hide on scroll
  hideOnScroll   : 'auto',

  // hide other popups on show
  exclusive      : false,

  // context to attach popups
  context        : 'body',

  // context for binding scroll events
  scrollContext  : window,

  // position to prefer when calculating new position
  prefer         : 'opposite',

  // specify position to appear even if it doesn't fit
  lastResort     : false,

  // number of pixels from edge of popup to pointing arrow center (used from centering)
  arrowPixelsFromEdge: 20,

  // delay used to prevent accidental refiring of animations due to user error
  delay : {
    show : 50,
    hide : 70
  },

  // whether fluid variation should assign width explicitly
  setFluidWidth  : true,

  // transition settings
  duration       : 200,
  transition     : 'scale',

  // distance away from activating element in px
  distanceAway   : 0,

  // number of pixels an element is allowed to be "offstage" for a position to be chosen (allows for rounding)
  jitter         : 2,

  // offset on aligning axis from calculated position
  offset         : 0,

  // maximum times to look for a position before failing (9 positions total)
  maxSearchDepth : 15,

  error: {
    invalidPosition : 'The position you specified is not a valid position',
    cannotPlace     : 'Popup does not fit within the boundaries of the viewport',
    method          : 'The method you called is not defined.',
    noTransition    : 'This module requires ui transitions <https://github.com/Semantic-Org/UI-Transition>',
    notFound        : 'The target or popup you specified does not exist on the page'
  },

  metadata: {
    activator : 'activator',
    content   : 'content',
    html      : 'html',
    offset    : 'offset',
    position  : 'position',
    title     : 'title',
    variation : 'variation'
  },

  className   : {
    active       : 'active',
    basic        : 'basic',
    animating    : 'animating',
    dropdown     : 'dropdown',
    fluid        : 'fluid',
    loading      : 'loading',
    popup        : 'ui popup',
    position     : 'top left center bottom right',
    visible      : 'visible',
    popupVisible : 'visible'
  },

  selector    : {
    popup    : '.ui.popup'
  },

  templates: {
    escape: function(string) {
      var
        badChars     = /[&<>"'`]/g,
        shouldEscape = /[&<>"'`]/,
        escape       = {
          "&": "&amp;",
          "<": "&lt;",
          ">": "&gt;",
          '"': "&quot;",
          "'": "&#x27;",
          "`": "&#x60;"
        },
        escapedChar  = function(chr) {
          return escape[chr];
        }
      ;
      if(shouldEscape.test(string)) {
        return string.replace(badChars, escapedChar);
      }
      return string;
    },
    popup: function(text) {
      var
        html   = '',
        escape = $.fn.popup.settings.templates.escape
      ;
      if(typeof text !== undefined) {
        if(typeof text.title !== undefined && text.title) {
          text.title = escape(text.title);
          html += '<div class="header">' + text.title + '</div>';
        }
        if(typeof text.content !== undefined && text.content) {
          text.content = escape(text.content);
          html += '<div class="content">' + text.content + '</div>';
        }
      }
      return html;
    }
  }

};


})( jQuery, window, document );

/*!
 * # Semantic UI 2.4.2 - Transition
 * http://github.com/semantic-org/semantic-ui/
 *
 *
 * Released under the MIT license
 * http://opensource.org/licenses/MIT
 *
 */

;(function ($, window, document, undefined) {

'use strict';

window = (typeof window != 'undefined' && window.Math == Math)
  ? window
  : (typeof self != 'undefined' && self.Math == Math)
    ? self
    : Function('return this')()
;

$.fn.transition = function() {
  var
    $allModules     = $(this),
    moduleSelector  = $allModules.selector || '',

    time            = new Date().getTime(),
    performance     = [],

    moduleArguments = arguments,
    query           = moduleArguments[0],
    queryArguments  = [].slice.call(arguments, 1),
    methodInvoked   = (typeof query === 'string'),

    requestAnimationFrame = window.requestAnimationFrame
      || window.mozRequestAnimationFrame
      || window.webkitRequestAnimationFrame
      || window.msRequestAnimationFrame
      || function(callback) { setTimeout(callback, 0); },

    returnedValue
  ;
  $allModules
    .each(function(index) {
      var
        $module  = $(this),
        element  = this,

        // set at run time
        settings,
        instance,

        error,
        className,
        metadata,
        animationEnd,
        animationName,

        namespace,
        moduleNamespace,
        eventNamespace,
        module
      ;

      module = {

        initialize: function() {

          // get full settings
          settings        = module.get.settings.apply(element, moduleArguments);

          // shorthand
          className       = settings.className;
          error           = settings.error;
          metadata        = settings.metadata;

          // define namespace
          eventNamespace  = '.' + settings.namespace;
          moduleNamespace = 'module-' + settings.namespace;
          instance        = $module.data(moduleNamespace) || module;

          // get vendor specific events
          animationEnd    = module.get.animationEndEvent();

          if(methodInvoked) {
            methodInvoked = module.invoke(query);
          }

          // method not invoked, lets run an animation
          if(methodInvoked === false) {
            module.verbose('Converted arguments into settings object', settings);
            if(settings.interval) {
              module.delay(settings.animate);
            }
            else  {
              module.animate();
            }
            module.instantiate();
          }
        },

        instantiate: function() {
          module.verbose('Storing instance of module', module);
          instance = module;
          $module
            .data(moduleNamespace, instance)
          ;
        },

        destroy: function() {
          module.verbose('Destroying previous module for', element);
          $module
            .removeData(moduleNamespace)
          ;
        },

        refresh: function() {
          module.verbose('Refreshing display type on next animation');
          delete module.displayType;
        },

        forceRepaint: function() {
          module.verbose('Forcing element repaint');
          var
            $parentElement = $module.parent(),
            $nextElement = $module.next()
          ;
          if($nextElement.length === 0) {
            $module.detach().appendTo($parentElement);
          }
          else {
            $module.detach().insertBefore($nextElement);
          }
        },

        repaint: function() {
          module.verbose('Repainting element');
          var
            fakeAssignment = element.offsetWidth
          ;
        },

        delay: function(interval) {
          var
            direction = module.get.animationDirection(),
            shouldReverse,
            delay
          ;
          if(!direction) {
            direction = module.can.transition()
              ? module.get.direction()
              : 'static'
            ;
          }
          interval = (interval !== undefined)
            ? interval
            : settings.interval
          ;
          shouldReverse = (settings.reverse == 'auto' && direction == className.outward);
          delay = (shouldReverse || settings.reverse == true)
            ? ($allModules.length - index) * settings.interval
            : index * settings.interval
          ;
          module.debug('Delaying animation by', delay);
          setTimeout(module.animate, delay);
        },

        animate: function(overrideSettings) {
          settings = overrideSettings || settings;
          if(!module.is.supported()) {
            module.error(error.support);
            return false;
          }
          module.debug('Preparing animation', settings.animation);
          if(module.is.animating()) {
            if(settings.queue) {
              if(!settings.allowRepeats && module.has.direction() && module.is.occurring() && module.queuing !== true) {
                module.debug('Animation is currently occurring, preventing queueing same animation', settings.animation);
              }
              else {
                module.queue(settings.animation);
              }
              return false;
            }
            else if(!settings.allowRepeats && module.is.occurring()) {
              module.debug('Animation is already occurring, will not execute repeated animation', settings.animation);
              return false;
            }
            else {
              module.debug('New animation started, completing previous early', settings.animation);
              instance.complete();
            }
          }
          if( module.can.animate() ) {
            module.set.animating(settings.animation);
          }
          else {
            module.error(error.noAnimation, settings.animation, element);
          }
        },

        reset: function() {
          module.debug('Resetting animation to beginning conditions');
          module.remove.animationCallbacks();
          module.restore.conditions();
          module.remove.animating();
        },

        queue: function(animation) {
          module.debug('Queueing animation of', animation);
          module.queuing = true;
          $module
            .one(animationEnd + '.queue' + eventNamespace, function() {
              module.queuing = false;
              module.repaint();
              module.animate.apply(this, settings);
            })
          ;
        },

        complete: function (event) {
          module.debug('Animation complete', settings.animation);
          module.remove.completeCallback();
          module.remove.failSafe();
          if(!module.is.looping()) {
            if( module.is.outward() ) {
              module.verbose('Animation is outward, hiding element');
              module.restore.conditions();
              module.hide();
            }
            else if( module.is.inward() ) {
              module.verbose('Animation is outward, showing element');
              module.restore.conditions();
              module.show();
            }
            else {
              module.verbose('Static animation completed');
              module.restore.conditions();
              settings.onComplete.call(element);
            }
          }
        },

        force: {
          visible: function() {
            var
              style          = $module.attr('style'),
              userStyle      = module.get.userStyle(),
              displayType    = module.get.displayType(),
              overrideStyle  = userStyle + 'display: ' + displayType + ' !important;',
              currentDisplay = $module.css('display'),
              emptyStyle     = (style === undefined || style === '')
            ;
            if(currentDisplay !== displayType) {
              module.verbose('Overriding default display to show element', displayType);
              $module
                .attr('style', overrideStyle)
              ;
            }
            else if(emptyStyle) {
              $module.removeAttr('style');
            }
          },
          hidden: function() {
            var
              style          = $module.attr('style'),
              currentDisplay = $module.css('display'),
              emptyStyle     = (style === undefined || style === '')
            ;
            if(currentDisplay !== 'none' && !module.is.hidden()) {
              module.verbose('Overriding default display to hide element');
              $module
                .css('display', 'none')
              ;
            }
            else if(emptyStyle) {
              $module
                .removeAttr('style')
              ;
            }
          }
        },

        has: {
          direction: function(animation) {
            var
              hasDirection = false
            ;
            animation = animation || settings.animation;
            if(typeof animation === 'string') {
              animation = animation.split(' ');
              $.each(animation, function(index, word){
                if(word === className.inward || word === className.outward) {
                  hasDirection = true;
                }
              });
            }
            return hasDirection;
          },
          inlineDisplay: function() {
            var
              style = $module.attr('style') || ''
            ;
            return $.isArray(style.match(/display.*?;/, ''));
          }
        },

        set: {
          animating: function(animation) {
            var
              animationClass,
              direction
            ;
            // remove previous callbacks
            module.remove.completeCallback();

            // determine exact animation
            animation      = animation || settings.animation;
            animationClass = module.get.animationClass(animation);

            // save animation class in cache to restore class names
            module.save.animation(animationClass);

            // override display if necessary so animation appears visibly
            module.force.visible();

            module.remove.hidden();
            module.remove.direction();

            module.start.animation(animationClass);

          },
          duration: function(animationName, duration) {
            duration = duration || settings.duration;
            duration = (typeof duration == 'number')
              ? duration + 'ms'
              : duration
            ;
            if(duration || duration === 0) {
              module.verbose('Setting animation duration', duration);
              $module
                .css({
                  'animation-duration':  duration
                })
              ;
            }
          },
          direction: function(direction) {
            direction = direction || module.get.direction();
            if(direction == className.inward) {
              module.set.inward();
            }
            else {
              module.set.outward();
            }
          },
          looping: function() {
            module.debug('Transition set to loop');
            $module
              .addClass(className.looping)
            ;
          },
          hidden: function() {
            $module
              .addClass(className.transition)
              .addClass(className.hidden)
            ;
          },
          inward: function() {
            module.debug('Setting direction to inward');
            $module
              .removeClass(className.outward)
              .addClass(className.inward)
            ;
          },
          outward: function() {
            module.debug('Setting direction to outward');
            $module
              .removeClass(className.inward)
              .addClass(className.outward)
            ;
          },
          visible: function() {
            $module
              .addClass(className.transition)
              .addClass(className.visible)
            ;
          }
        },

        start: {
          animation: function(animationClass) {
            animationClass = animationClass || module.get.animationClass();
            module.debug('Starting tween', animationClass);
            $module
              .addClass(animationClass)
              .one(animationEnd + '.complete' + eventNamespace, module.complete)
            ;
            if(settings.useFailSafe) {
              module.add.failSafe();
            }
            module.set.duration(settings.duration);
            settings.onStart.call(element);
          }
        },

        save: {
          animation: function(animation) {
            if(!module.cache) {
              module.cache = {};
            }
            module.cache.animation = animation;
          },
          displayType: function(displayType) {
            if(displayType !== 'none') {
              $module.data(metadata.displayType, displayType);
            }
          },
          transitionExists: function(animation, exists) {
            $.fn.transition.exists[animation] = exists;
            module.verbose('Saving existence of transition', animation, exists);
          }
        },

        restore: {
          conditions: function() {
            var
              animation = module.get.currentAnimation()
            ;
            if(animation) {
              $module
                .removeClass(animation)
              ;
              module.verbose('Removing animation class', module.cache);
            }
            module.remove.duration();
          }
        },

        add: {
          failSafe: function() {
            var
              duration = module.get.duration()
            ;
            module.timer = setTimeout(function() {
              $module.triggerHandler(animationEnd);
            }, duration + settings.failSafeDelay);
            module.verbose('Adding fail safe timer', module.timer);
          }
        },

        remove: {
          animating: function() {
            $module.removeClass(className.animating);
          },
          animationCallbacks: function() {
            module.remove.queueCallback();
            module.remove.completeCallback();
          },
          queueCallback: function() {
            $module.off('.queue' + eventNamespace);
          },
          completeCallback: function() {
            $module.off('.complete' + eventNamespace);
          },
          display: function() {
            $module.css('display', '');
          },
          direction: function() {
            $module
              .removeClass(className.inward)
              .removeClass(className.outward)
            ;
          },
          duration: function() {
            $module
              .css('animation-duration', '')
            ;
          },
          failSafe: function() {
            module.verbose('Removing fail safe timer', module.timer);
            if(module.timer) {
              clearTimeout(module.timer);
            }
          },
          hidden: function() {
            $module.removeClass(className.hidden);
          },
          visible: function() {
            $module.removeClass(className.visible);
          },
          looping: function() {
            module.debug('Transitions are no longer looping');
            if( module.is.looping() ) {
              module.reset();
              $module
                .removeClass(className.looping)
              ;
            }
          },
          transition: function() {
            $module
              .removeClass(className.visible)
              .removeClass(className.hidden)
            ;
          }
        },
        get: {
          settings: function(animation, duration, onComplete) {
            // single settings object
            if(typeof animation == 'object') {
              return $.extend(true, {}, $.fn.transition.settings, animation);
            }
            // all arguments provided
            else if(typeof onComplete == 'function') {
              return $.extend({}, $.fn.transition.settings, {
                animation  : animation,
                onComplete : onComplete,
                duration   : duration
              });
            }
            // only duration provided
            else if(typeof duration == 'string' || typeof duration == 'number') {
              return $.extend({}, $.fn.transition.settings, {
                animation : animation,
                duration  : duration
              });
            }
            // duration is actually settings object
            else if(typeof duration == 'object') {
              return $.extend({}, $.fn.transition.settings, duration, {
                animation : animation
              });
            }
            // duration is actually callback
            else if(typeof duration == 'function') {
              return $.extend({}, $.fn.transition.settings, {
                animation  : animation,
                onComplete : duration
              });
            }
            // only animation provided
            else {
              return $.extend({}, $.fn.transition.settings, {
                animation : animation
              });
            }
          },
          animationClass: function(animation) {
            var
              animationClass = animation || settings.animation,
              directionClass = (module.can.transition() && !module.has.direction())
                ? module.get.direction() + ' '
                : ''
            ;
            return className.animating + ' '
              + className.transition + ' '
              + directionClass
              + animationClass
            ;
          },
          currentAnimation: function() {
            return (module.cache && module.cache.animation !== undefined)
              ? module.cache.animation
              : false
            ;
          },
          currentDirection: function() {
            return module.is.inward()
              ? className.inward
              : className.outward
            ;
          },
          direction: function() {
            return module.is.hidden() || !module.is.visible()
              ? className.inward
              : className.outward
            ;
          },
          animationDirection: function(animation) {
            var
              direction
            ;
            animation = animation || settings.animation;
            if(typeof animation === 'string') {
              animation = animation.split(' ');
              // search animation name for out/in class
              $.each(animation, function(index, word){
                if(word === className.inward) {
                  direction = className.inward;
                }
                else if(word === className.outward) {
                  direction = className.outward;
                }
              });
            }
            // return found direction
            if(direction) {
              return direction;
            }
            return false;
          },
          duration: function(duration) {
            duration = duration || settings.duration;
            if(duration === false) {
              duration = $module.css('animation-duration') || 0;
            }
            return (typeof duration === 'string')
              ? (duration.indexOf('ms') > -1)
                ? parseFloat(duration)
                : parseFloat(duration) * 1000
              : duration
            ;
          },
          displayType: function(shouldDetermine) {
            shouldDetermine = (shouldDetermine !== undefined)
              ? shouldDetermine
              : true
            ;
            if(settings.displayType) {
              return settings.displayType;
            }
            if(shouldDetermine && $module.data(metadata.displayType) === undefined) {
              // create fake element to determine display state
              module.can.transition(true);
            }
            return $module.data(metadata.displayType);
          },
          userStyle: function(style) {
            style = style || $module.attr('style') || '';
            return style.replace(/display.*?;/, '');
          },
          transitionExists: function(animation) {
            return $.fn.transition.exists[animation];
          },
          animationStartEvent: function() {
            var
              element     = document.createElement('div'),
              animations  = {
                'animation'       :'animationstart',
                'OAnimation'      :'oAnimationStart',
                'MozAnimation'    :'mozAnimationStart',
                'WebkitAnimation' :'webkitAnimationStart'
              },
              animation
            ;
            for(animation in animations){
              if( element.style[animation] !== undefined ){
                return animations[animation];
              }
            }
            return false;
          },
          animationEndEvent: function() {
            var
              element     = document.createElement('div'),
              animations  = {
                'animation'       :'animationend',
                'OAnimation'      :'oAnimationEnd',
                'MozAnimation'    :'mozAnimationEnd',
                'WebkitAnimation' :'webkitAnimationEnd'
              },
              animation
            ;
            for(animation in animations){
              if( element.style[animation] !== undefined ){
                return animations[animation];
              }
            }
            return false;
          }

        },

        can: {
          transition: function(forced) {
            var
              animation         = settings.animation,
              transitionExists  = module.get.transitionExists(animation),
              displayType       = module.get.displayType(false),
              elementClass,
              tagName,
              $clone,
              currentAnimation,
              inAnimation,
              directionExists
            ;
            if( transitionExists === undefined || forced) {
              module.verbose('Determining whether animation exists');
              elementClass = $module.attr('class');
              tagName      = $module.prop('tagName');

              $clone = $('<' + tagName + ' />').addClass( elementClass ).insertAfter($module);
              currentAnimation = $clone
                .addClass(animation)
                .removeClass(className.inward)
                .removeClass(className.outward)
                .addClass(className.animating)
                .addClass(className.transition)
                .css('animationName')
              ;
              inAnimation = $clone
                .addClass(className.inward)
                .css('animationName')
              ;
              if(!displayType) {
                displayType = $clone
                  .attr('class', elementClass)
                  .removeAttr('style')
                  .removeClass(className.hidden)
                  .removeClass(className.visible)
                  .show()
                  .css('display')
                ;
                module.verbose('Determining final display state', displayType);
                module.save.displayType(displayType);
              }

              $clone.remove();
              if(currentAnimation != inAnimation) {
                module.debug('Direction exists for animation', animation);
                directionExists = true;
              }
              else if(currentAnimation == 'none' || !currentAnimation) {
                module.debug('No animation defined in css', animation);
                return;
              }
              else {
                module.debug('Static animation found', animation, displayType);
                directionExists = false;
              }
              module.save.transitionExists(animation, directionExists);
            }
            return (transitionExists !== undefined)
              ? transitionExists
              : directionExists
            ;
          },
          animate: function() {
            // can transition does not return a value if animation does not exist
            return (module.can.transition() !== undefined);
          }
        },

        is: {
          animating: function() {
            return $module.hasClass(className.animating);
          },
          inward: function() {
            return $module.hasClass(className.inward);
          },
          outward: function() {
            return $module.hasClass(className.outward);
          },
          looping: function() {
            return $module.hasClass(className.looping);
          },
          occurring: function(animation) {
            animation = animation || settings.animation;
            animation = '.' + animation.replace(' ', '.');
            return ( $module.filter(animation).length > 0 );
          },
          visible: function() {
            return $module.is(':visible');
          },
          hidden: function() {
            return $module.css('visibility') === 'hidden';
          },
          supported: function() {
            return(animationEnd !== false);
          }
        },

        hide: function() {
          module.verbose('Hiding element');
          if( module.is.animating() ) {
            module.reset();
          }
          element.blur(); // IE will trigger focus change if element is not blurred before hiding
          module.remove.display();
          module.remove.visible();
          module.set.hidden();
          module.force.hidden();
          settings.onHide.call(element);
          settings.onComplete.call(element);
          // module.repaint();
        },

        show: function(display) {
          module.verbose('Showing element', display);
          module.remove.hidden();
          module.set.visible();
          module.force.visible();
          settings.onShow.call(element);
          settings.onComplete.call(element);
          // module.repaint();
        },

        toggle: function() {
          if( module.is.visible() ) {
            module.hide();
          }
          else {
            module.show();
          }
        },

        stop: function() {
          module.debug('Stopping current animation');
          $module.triggerHandler(animationEnd);
        },

        stopAll: function() {
          module.debug('Stopping all animation');
          module.remove.queueCallback();
          $module.triggerHandler(animationEnd);
        },

        clear: {
          queue: function() {
            module.debug('Clearing animation queue');
            module.remove.queueCallback();
          }
        },

        enable: function() {
          module.verbose('Starting animation');
          $module.removeClass(className.disabled);
        },

        disable: function() {
          module.debug('Stopping animation');
          $module.addClass(className.disabled);
        },

        setting: function(name, value) {
          module.debug('Changing setting', name, value);
          if( $.isPlainObject(name) ) {
            $.extend(true, settings, name);
          }
          else if(value !== undefined) {
            if($.isPlainObject(settings[name])) {
              $.extend(true, settings[name], value);
            }
            else {
              settings[name] = value;
            }
          }
          else {
            return settings[name];
          }
        },
        internal: function(name, value) {
          if( $.isPlainObject(name) ) {
            $.extend(true, module, name);
          }
          else if(value !== undefined) {
            module[name] = value;
          }
          else {
            return module[name];
          }
        },
        debug: function() {
          if(!settings.silent && settings.debug) {
            if(settings.performance) {
              module.performance.log(arguments);
            }
            else {
              module.debug = Function.prototype.bind.call(console.info, console, settings.name + ':');
              module.debug.apply(console, arguments);
            }
          }
        },
        verbose: function() {
          if(!settings.silent && settings.verbose && settings.debug) {
            if(settings.performance) {
              module.performance.log(arguments);
            }
            else {
              module.verbose = Function.prototype.bind.call(console.info, console, settings.name + ':');
              module.verbose.apply(console, arguments);
            }
          }
        },
        error: function() {
          if(!settings.silent) {
            module.error = Function.prototype.bind.call(console.error, console, settings.name + ':');
            module.error.apply(console, arguments);
          }
        },
        performance: {
          log: function(message) {
            var
              currentTime,
              executionTime,
              previousTime
            ;
            if(settings.performance) {
              currentTime   = new Date().getTime();
              previousTime  = time || currentTime;
              executionTime = currentTime - previousTime;
              time          = currentTime;
              performance.push({
                'Name'           : message[0],
                'Arguments'      : [].slice.call(message, 1) || '',
                'Element'        : element,
                'Execution Time' : executionTime
              });
            }
            clearTimeout(module.performance.timer);
            module.performance.timer = setTimeout(module.performance.display, 500);
          },
          display: function() {
            var
              title = settings.name + ':',
              totalTime = 0
            ;
            time = false;
            clearTimeout(module.performance.timer);
            $.each(performance, function(index, data) {
              totalTime += data['Execution Time'];
            });
            title += ' ' + totalTime + 'ms';
            if(moduleSelector) {
              title += ' \'' + moduleSelector + '\'';
            }
            if($allModules.length > 1) {
              title += ' ' + '(' + $allModules.length + ')';
            }
            if( (console.group !== undefined || console.table !== undefined) && performance.length > 0) {
              console.groupCollapsed(title);
              if(console.table) {
                console.table(performance);
              }
              else {
                $.each(performance, function(index, data) {
                  console.log(data['Name'] + ': ' + data['Execution Time']+'ms');
                });
              }
              console.groupEnd();
            }
            performance = [];
          }
        },
        // modified for transition to return invoke success
        invoke: function(query, passedArguments, context) {
          var
            object = instance,
            maxDepth,
            found,
            response
          ;
          passedArguments = passedArguments || queryArguments;
          context         = element         || context;
          if(typeof query == 'string' && object !== undefined) {
            query    = query.split(/[\. ]/);
            maxDepth = query.length - 1;
            $.each(query, function(depth, value) {
              var camelCaseValue = (depth != maxDepth)
                ? value + query[depth + 1].charAt(0).toUpperCase() + query[depth + 1].slice(1)
                : query
              ;
              if( $.isPlainObject( object[camelCaseValue] ) && (depth != maxDepth) ) {
                object = object[camelCaseValue];
              }
              else if( object[camelCaseValue] !== undefined ) {
                found = object[camelCaseValue];
                return false;
              }
              else if( $.isPlainObject( object[value] ) && (depth != maxDepth) ) {
                object = object[value];
              }
              else if( object[value] !== undefined ) {
                found = object[value];
                return false;
              }
              else {
                return false;
              }
            });
          }
          if ( $.isFunction( found ) ) {
            response = found.apply(context, passedArguments);
          }
          else if(found !== undefined) {
            response = found;
          }

          if($.isArray(returnedValue)) {
            returnedValue.push(response);
          }
          else if(returnedValue !== undefined) {
            returnedValue = [returnedValue, response];
          }
          else if(response !== undefined) {
            returnedValue = response;
          }
          return (found !== undefined)
            ? found
            : false
          ;
        }
      };
      module.initialize();
    })
  ;
  return (returnedValue !== undefined)
    ? returnedValue
    : this
  ;
};

// Records if CSS transition is available
$.fn.transition.exists = {};

$.fn.transition.settings = {

  // module info
  name          : 'Transition',

  // hide all output from this component regardless of other settings
  silent        : false,

  // debug content outputted to console
  debug         : false,

  // verbose debug output
  verbose       : false,

  // performance data output
  performance   : true,

  // event namespace
  namespace     : 'transition',

  // delay between animations in group
  interval      : 0,

  // whether group animations should be reversed
  reverse       : 'auto',

  // animation callback event
  onStart       : function() {},
  onComplete    : function() {},
  onShow        : function() {},
  onHide        : function() {},

  // whether timeout should be used to ensure callback fires in cases animationend does not
  useFailSafe   : true,

  // delay in ms for fail safe
  failSafeDelay : 100,

  // whether EXACT animation can occur twice in a row
  allowRepeats  : false,

  // Override final display type on visible
  displayType   : false,

  // animation duration
  animation     : 'fade',
  duration      : false,

  // new animations will occur after previous ones
  queue         : true,

  metadata : {
    displayType: 'display'
  },

  className   : {
    animating  : 'animating',
    disabled   : 'disabled',
    hidden     : 'hidden',
    inward     : 'in',
    loading    : 'loading',
    looping    : 'looping',
    outward    : 'out',
    transition : 'transition',
    visible    : 'visible'
  },

  // possible errors
  error: {
    noAnimation : 'Element is no longer attached to DOM. Unable to animate.  Use silent setting to surpress this warning in production.',
    repeated    : 'That animation is already occurring, cancelling repeated animation',
    method      : 'The method you called is not defined',
    support     : 'This browser does not support CSS animations'
  }

};


})( jQuery, window, document );
