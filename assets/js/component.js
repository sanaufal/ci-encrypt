function ReadMore() {
	var readMoreTxt = 'Read more',
		readLessTxt = 'Read less';

	$('.read-more').each(function () {
		if ($(this).find('.first-letter').length)
			return;

		var carLimit = $(this).attr('data-characters') || 200;
		var ellipsis = $(this).attr('data-ellipsis') && $(this).attr('data-ellipsis') == 'off' ? false : true;
		var btnLess = ' <button class="btn-read-less" title="click to read less">' + readLessTxt + '</button>';
		var btnMore = ' <button class="btn-read-more" title="click to show">' + readMoreTxt + '</button> ';

		var allstr = $(this).text();
		if (allstr.length > carLimit) {
			var firstSet = allstr.substring(0, carLimit);
			firstSet = firstSet.substring(0, Math.min(firstSet.length, firstSet.lastIndexOf(" ")));
			var scdHalf = allstr.substring(carLimit, allstr.length);
		}
		if (ellipsis == true) {
			btnMore = '<span class="read-more-ellipsis" aria-hidden="true">. . .</span>' + btnMore;
		}
		var strtoadd = firstSet + '<span class="read-more-content is-hidden">' + scdHalf + '</span>' + btnMore + btnLess;
		$(this).html(strtoadd);
	});

	$(document).on('click', '.btn-read-more, .btn-read-less', function () {
		$(this).closest('.read-more').toggleClass('read-less-content read-more-content').find('.read-more-content').toggleClass('is-hidden');
	});
};

function removeHash() {
	history.replaceState('', document.title, window.location.origin + window.location.pathname + window.location.search);
};

function SmoothScroll() {
	$('.smooth-scroll').on('click', function (event) {
		if (this.hash !== '') {
			event.preventDefault();

			var hash = this.hash;

			$('html, body').animate({
				scrollTop: $(hash).offset().top
			}, 300, function () {
				window.location.hash = hash;
				removeHash();
			});
		}
	});
};

function showPassword() {
	var passwordInput = $('.password-input');
	var visibilityBtn = $('.password-btn');
	var visibilityClass = 'password-text-is-visible';
	var initPassword = $('.password');

	visibilityBtn.on('click', function (e) {
		e.preventDefault();
		$(this).parent().toggleClass(visibilityClass);
		if (initPassword.hasClass(visibilityClass)) {
			$(this).parent(initPassword).find(passwordInput).attr('type', 'text');
		} else {
			$(this).parent(initPassword).find(passwordInput).attr('type', 'password');
		}
	});
};

(function () {
	var CharacterCount = function (element) {
		this.element = element;
		this.input = this.element.getElementsByClassName('character-count-input')[0];
		this.characterLimit = Number(this.input.getAttribute('maxlength')) || 200;
		this.counter = this.element.getElementsByClassName('character-count-counter')[0];
		this.initCount();
	};

	CharacterCount.prototype.initCount = function () {
		var self = this;
		this.counter.textContent = this.getCount();
		this.input.addEventListener('input', function (event) {
			self.counter.textContent = self.getCount();
		});
	};

	CharacterCount.prototype.getCount = function () {
		return this.characterLimit - this.input.value.length;
	};

	var characterCounts = document.getElementsByClassName('character-count');
	if (characterCounts.length > 0) {
		for (var i = 0; i < characterCounts.length; i++) {
			(function (i) {
				new CharacterCount(characterCounts[i]);
			})(i);
		}
	};
}());

(function () {
	var InputNumber = function (element) {
		this.element = element;
		this.input = this.element.getElementsByClassName('number-input-value')[0];
		this.min = parseFloat(this.input.getAttribute('min'));
		this.max = parseFloat(this.input.getAttribute('max'));
		this.step = parseFloat(this.input.getAttribute('step'));
		if (isNaN(this.step)) this.step = 1;
		this.precision = getStepPrecision(this.step);
		initInputNumberEvents(this);
	};

	function initInputNumberEvents(input) {
		// listen to the click event on the custom increment buttons
		input.element.addEventListener('click', function (event) {
			var increment = event.target.closest('.number-input-btn');
			if (increment) {
				event.preventDefault();
				updateInputNumber(input, increment);
			}
		});

		// when input changes, make sure the new value is acceptable
		input.input.addEventListener('focusout', function (event) {
			var value = parseFloat(input.input.value);
			if (value < input.min) value = input.min;
			if (value > input.max) value = input.max;
			// check value is multiple of step
			value = checkIsMultipleStep(input, value);
			if (value != parseFloat(input.input.value)) input.input.value = value;

		});
	};

	function getStepPrecision(step) {
		// if step is a floating number, return its precision
		return (step.toString().length - Math.floor(step).toString().length - 1);
	};

	function updateInputNumber(input, btn) {
		var value = (Util.hasClass(btn, 'number-input-btn-plus')) ? parseFloat(input.input.value) + input.step : parseFloat(input.input.value) - input.step;
		if (input.precision > 0) value = value.toFixed(input.precision);
		if (value < input.min) value = input.min;
		if (value > input.max) value = input.max;
		input.input.value = value;
		input.input.dispatchEvent(new CustomEvent('change', {
			bubbles: true
		})); // trigger change event
	};

	function checkIsMultipleStep(input, value) {
		// check if the number inserted is a multiple of the step value
		var remain = (value * 10 * input.precision) % (input.step * 10 * input.precision);
		if (remain != 0) value = value - remain;
		if (input.precision > 0) value = value.toFixed(input.precision);
		return value;
	};

	//initialize the InputNumber objects
	var inputNumbers = document.getElementsByClassName('number-input');
	if (inputNumbers.length > 0) {
		for (var i = 0; i < inputNumbers.length; i++) {
			(function (i) {
				new InputNumber(inputNumbers[i]);
			})(i);
		}
	}
}());

(function () {
	var Dialog = function (element) {
		this.element = element;
		this.triggers = document.querySelectorAll('[aria-controls="' + this.element.getAttribute('id') + '"]');
		this.firstFocusable = null;
		this.lastFocusable = null;
		this.selectedTrigger = null;
		this.showClass = "dialog-is-visible";
		initDialog(this);
	};

	function initDialog(dialog) {
		if (dialog.triggers) {
			for (var i = 0; i < dialog.triggers.length; i++) {
				dialog.triggers[i].addEventListener('click', function (event) {
					event.preventDefault();
					dialog.selectedTrigger = event.target;
					showDialog(dialog);
					initDialogEvents(dialog);
				});
			}
		}

		// listen to the openDialog event -> open dialog without a trigger button
		dialog.element.addEventListener('openDialog', function (event) {
			if (event.detail) self.selectedTrigger = event.detail;
			showDialog(dialog);
			initDialogEvents(dialog);
		});
	};

	function showDialog(dialog) {
		Util.addClass(dialog.element, dialog.showClass);
		getFocusableElements(dialog);
		dialog.firstFocusable.focus();
		// wait for the end of transitions before moving focus
		dialog.element.addEventListener("transitionend", function cb(event) {
			dialog.firstFocusable.focus();
			dialog.element.removeEventListener("transitionend", cb);
		});
		emitDialogEvents(dialog, 'dialogIsOpen');
	};

	function closeDialog(dialog) {
		Util.removeClass(dialog.element, dialog.showClass);
		dialog.firstFocusable = null;
		dialog.lastFocusable = null;
		if (dialog.selectedTrigger) dialog.selectedTrigger.focus();
		//remove listeners
		cancelDialogEvents(dialog);
		emitDialogEvents(dialog, 'dialogIsClose');
	};

	function initDialogEvents(dialog) {
		//add event listeners
		dialog.element.addEventListener('keydown', handleEvent.bind(dialog));
		dialog.element.addEventListener('click', handleEvent.bind(dialog));
	};

	function cancelDialogEvents(dialog) {
		//remove event listeners
		dialog.element.removeEventListener('keydown', handleEvent.bind(dialog));
		dialog.element.removeEventListener('click', handleEvent.bind(dialog));
	};

	function handleEvent(event) {
		// handle events
		switch (event.type) {
			case 'click': {
				initClick(this, event);
			}
			case 'keydown': {
				initKeyDown(this, event);
			}
		}
	};

	function initKeyDown(dialog, event) {
		if (event.keyCode && event.keyCode == 27 || event.key && event.key == 'Escape') {
			//close dialog on esc
			closeDialog(dialog);
		} else if (event.keyCode && event.keyCode == 9 || event.key && event.key == 'Tab') {
			//trap focus inside dialog
			trapFocus(dialog, event);
		}
	};

	function initClick(dialog, event) {
		//close dialog when clicking on close button
		if (!event.target.closest('[data-dismiss="dialog"]')) return;
		event.preventDefault();
		closeDialog(dialog);
	};

	function trapFocus(dialog, event) {
		if (dialog.firstFocusable == document.activeElement && event.shiftKey) {
			//on Shift+Tab -> focus last focusable element when focus moves out of dialog
			event.preventDefault();
			dialog.lastFocusable.focus();
		}
		if (dialog.lastFocusable == document.activeElement && !event.shiftKey) {
			//on Tab -> focus first focusable element when focus moves out of dialog
			event.preventDefault();
			dialog.firstFocusable.focus();
		}
	};

	function getFocusableElements(dialog) {
		//get all focusable elements inside the dialog
		var allFocusable = dialog.element.querySelectorAll('[href], input:not([disabled]), select:not([disabled]), textarea:not([disabled]), button:not([disabled]), iframe, object, embed, [tabindex]:not([tabindex="-1"]), [contenteditable], audio[controls], video[controls], summary');
		getFirstVisible(dialog, allFocusable);
		getLastVisible(dialog, allFocusable);
	};

	function getFirstVisible(dialog, elements) {
		//get first visible focusable element inside the dialog
		for (var i = 0; i < elements.length; i++) {
			if (elements[i].offsetWidth || elements[i].offsetHeight || elements[i].getClientRects().length) {
				dialog.firstFocusable = elements[i];
				return true;
			}
		}
	};

	function getLastVisible(dialog, elements) {
		//get last visible focusable element inside the dialog
		for (var i = elements.length - 1; i >= 0; i--) {
			if (elements[i].offsetWidth || elements[i].offsetHeight || elements[i].getClientRects().length) {
				dialog.lastFocusable = elements[i];
				return true;
			}
		}
	};

	function emitDialogEvents(dialog, eventName) {
		var event = new CustomEvent(eventName, {
			detail: dialog.selectedTrigger
		});
		dialog.element.dispatchEvent(event);
	};

	//initialize the Dialog objects
	var dialogs = document.getElementsByClassName('dialog');
	if (dialogs.length > 0) {
		for (var i = 0; i < dialogs.length; i++) {
			(function (i) {
				new Dialog(dialogs[i]);
			})(i);
		}
	}
}());

(function () {
	var Details = function (element, index) {
		this.element = element;
		this.summary = this.element.getElementsByClassName('details-summary')[0];
		this.details = this.element.getElementsByClassName('details-content')[0];
		this.htmlElSupported = 'open' in this.element;
		this.initDetails(index);
		this.initDetailsEvents();
	};

	Details.prototype.initDetails = function (index) {
		// init aria attributes 
		Util.setAttributes(this.summary, {
			'aria-expanded': 'false',
			'aria-controls': 'details-' + index,
			'role': 'button'
		});
		Util.setAttributes(this.details, {
			'aria-hidden': 'true',
			'id': 'details-' + index
		});
	};

	Details.prototype.initDetailsEvents = function () {
		var self = this;
		if (this.htmlElSupported) { // browser supports the <details> element 
			this.element.addEventListener('toggle', function (event) {
				var ariaValues = self.element.open ? ['true', 'false'] : ['false', 'true'];
				// update aria attributes when details element status change (open/close)
				self.updateAriaValues(ariaValues);
			});
		} else { //browser does not support <details>
			this.summary.addEventListener('click', function (event) {
				event.preventDefault();
				var isOpen = self.element.getAttribute('open'),
					ariaValues = [];

				isOpen ? self.element.removeAttribute('open') : self.element.setAttribute('open', 'true');
				ariaValues = isOpen ? ['false', 'true'] : ['true', 'false'];
				self.updateAriaValues(ariaValues);
			});
		}
	};

	Details.prototype.updateAriaValues = function (values) {
		this.summary.setAttribute('aria-expanded', values[0]);
		this.details.setAttribute('aria-hidden', values[1]);
	};

	//initialize the Details objects
	var detailsEl = document.getElementsByClassName('details');
	if (detailsEl.length > 0) {
		for (var i = 0; i < detailsEl.length; i++) {
			(function (i) {
				new Details(detailsEl[i], i);
			})(i);
		}
	}
}());

// animation menu button
(function () {
	var menuBtns = document.getElementsByClassName('anim-menu-btn');
	if (menuBtns.length > 0) {
		for (var i = 0; i < menuBtns.length; i++) {
			(function (i) {
				initMenuBtn(menuBtns[i]);
			})(i);
		}

		function initMenuBtn(btn) {
			btn.addEventListener('click', function (event) {
				event.preventDefault();
				var status = !Util.hasClass(btn, 'anim-menu-btn-state-b');
				Util.toggleClass(btn, 'anim-menu-btn-state-b', status);

				var event = new CustomEvent('anim-menu-btn-clicked', {
					detail: status
				});
				btn.dispatchEvent(event);
			});
		};
	}
}());

// switch icon
(function () {
	var switchIcons = document.getElementsByClassName('switch-icon');
	if (switchIcons.length > 0) {
		for (var i = 0; i < switchIcons.length; i++) {
			(function (i) {
				if (!Util.hasClass(switchIcons[i], 'switch-icon-hover')) initswitchIcons(switchIcons[i]);
			})(i);
		}

		function initswitchIcons(btn) {
			btn.addEventListener('click', function (event) {
				event.preventDefault();
				var status = !Util.hasClass(btn, 'switch-icon-state-b');
				Util.toggleClass(btn, 'switch-icon-state-b', status);

				var event = new CustomEvent('switch-icon-clicked', {
					detail: status
				});
				btn.dispatchEvent(event);
			});
		};
	}
}());

// button slide fx
(function () {
	var BtnSlideFx = function (element) {
		this.element = element;
		this.hover = false;
		btnSlideFxEvents(this);
	};

	function btnSlideFxEvents(btn) {
		btn.element.addEventListener('mouseenter', function (event) {
			btn.hover = true;
			triggerBtnSlideFxAnimation(btn.element, 'from');
		});

		btn.element.addEventListener('mouseleave', function (event) {
			btn.hover = false;
			triggerBtnSlideFxAnimation(btn.element, 'to');
		});

		btn.element.addEventListener('transitionend', function (event) {
			resetBtnSlideFxAnimation(btn.element);
		});
	};

	function getEnterDirection(element, event) {
		var deltaLeft = Math.abs(element.getBoundingClientRect().left - event.clientX),
			deltaRight = Math.abs(element.getBoundingClientRect().right - event.clientX),
			deltaTop = Math.abs(element.getBoundingClientRect().top - event.clientY),
			deltaBottom = Math.abs(element.getBoundingClientRect().bottom - event.clientY);

		var deltaXDir = (deltaLeft < deltaRight) ? 'left' : 'right',
			deltaX = (deltaLeft < deltaRight) ? deltaLeft : deltaRight,
			deltaYDir = (deltaTop < deltaBottom) ? 'top' : 'bottom',
			deltaY = (deltaTop < deltaBottom) ? deltaTop : deltaBottom;

		return (deltaX < deltaY) ? deltaXDir : deltaYDir;
	};

	function triggerBtnSlideFxAnimation(element, direction) { // trigger animation -> apply in/out and direction classes
		var inStep = (direction == 'from') ? '-out' : '',
			outStep = (direction == 'from') ? '' : '-out';
		Util.removeClass(element, 'btn-slide-fx-hover' + inStep);
		resetBtnSlideFxAnimation(element);
		Util.addClass(element, 'btn-slide-fx-' + direction + '-' + getEnterDirection(element, event)); // set direction 
		setTimeout(function () {
			Util.addClass(element, 'btn-slide-fx-animate');
		}, 5); // add transition
		setTimeout(function () {
			Util.addClass(element, 'btn-slide-fx-hover' + outStep);
		}, 10); // trigger transition
	};

	function resetBtnSlideFxAnimation(element) { // remove animation classes
		Util.removeClass(element, 'btn-slide-fx-from-left btn-slide-fx-from-right btn-slide-fx-from-bottom btn-slide-fx-from-top btn-slide-fx-to-left btn-slide-fx-to-right btn-slide-fx-to-bottom btn-slide-fx-to-top btn-slide-fx-animate');
	};

	var btnSlideFx = document.getElementsByClassName('btn-slide-fx');
	if (btnSlideFx.length > 0) {
		for (var i = 0; i < btnSlideFx.length; i++) {
			(function (i) {
				new BtnSlideFx(btnSlideFx[i]);
			})(i);
		}
	}
}());

(function () {
	var ProgressBar = function (element) {
		this.element = element;
		this.fill = this.element.getElementsByClassName('progress-bar-fill')[0];
		this.label = this.element.getElementsByClassName('progress-bar-value');
		this.value = getProgressBarValue(this);
		// before checking if data-animation is set -> check for reduced motion
		updatedProgressBarForReducedMotion(this);
		this.animate = this.element.hasAttribute('data-animation') && this.element.getAttribute('data-animation') == 'on';
		this.animationDuration = this.element.hasAttribute('data-duration') ? this.element.getAttribute('data-duration') : 1000;
		// animation will run only on browsers supporting IntersectionObserver
		this.canAnimate = ('IntersectionObserver' in window && 'IntersectionObserverEntry' in window && 'intersectionRatio' in window.IntersectionObserverEntry.prototype);
		// this element is used to announce the percentage value to SR
		this.ariaLabel = this.element.getElementsByClassName('progress-bar-aria-value');
		// check if we need to update the bar color
		this.changeColor = Util.hasClass(this.element, 'progress-bar-color-update') && Util.cssSupports('color', 'var(--color-value)');
		if (this.changeColor) {
			this.colorThresholds = getProgressBarColorThresholds(this);
		}
		initProgressBar(this);
		// store id to reset animation
		this.animationId = false;
	};

	// public function
	ProgressBar.prototype.setProgressBarValue = function (value) {
		setProgressBarValue(this, value);
	};

	function getProgressBarValue(progressBar) { // get progress value
		// return (fill width/total width) * 100
		return parseFloat(progressBar.fill.offsetWidth * 100 / progressBar.element.getElementsByClassName('progress-bar-bg')[0].offsetWidth);
	};

	function getProgressBarColorThresholds(progressBar) {
		var thresholds = [];
		var i = 1;
		while (!isNaN(parseInt(getComputedStyle(progressBar.element).getPropertyValue('--progress-bar-color' + i)))) {
			thresholds.push(parseInt(getComputedStyle(progressBar.element).getPropertyValue('--progress-bar-color' + i)));
			i = i + 1;
		}
		return thresholds;
	};

	function updatedProgressBarForReducedMotion(progressBar) {
		// if reduced motion is supported and set to reduced -> remove animations
		if (osHasReducedMotion) progressBar.element.removeAttribute('data-animation');
	};

	function initProgressBar(progressBar) {
		// set initial bar color
		if (progressBar.changeColor) updateProgressBarColor(progressBar, progressBar.value);
		// if data-animation is on -> reset the progress bar and animate when entering the viewport
		if (progressBar.animate && progressBar.canAnimate) animateProgressBar(progressBar);
		// reveal fill and label -> --animate and --color-update variations only
		setTimeout(function () {
			Util.addClass(progressBar.element, 'progress-bar-init');
		}, 30);

		// dynamically update value of progress bar
		progressBar.element.addEventListener('updateProgress', function (event) {
			// cancel request animation frame if it was animating
			if (progressBar.animationId) window.cancelAnimationFrame(progressBar.animationId);

			var final = event.detail.value,
				duration = (event.detail.duration) ? event.detail.duration : progressBar.animationDuration;
			var start = getProgressBarValue(progressBar);
			// trigger update animation
			updateProgressBar(progressBar, start, final, duration, function () {
				emitProgressBarEvents(progressBar, 'progressCompleted', progressBar.value + '%');
				// update value of label for SR
				if (progressBar.ariaLabel.length > 0) progressBar.ariaLabel[0].textContent = final + '%';
			});
		});
	};

	function animateProgressBar(progressBar) {
		// reset inital values
		setProgressBarValue(progressBar, 0);

		// listen for the element to enter the viewport -> start animation
		var observer = new IntersectionObserver(progressBarObserve.bind(progressBar), {
			threshold: [0, 0.1]
		});
		observer.observe(progressBar.element);
	};

	function progressBarObserve(entries, observer) { // observe progressBar position -> start animation when inside viewport
		var self = this;
		if (entries[0].intersectionRatio.toFixed(1) > 0 && !this.animationTriggered) {
			updateProgressBar(this, 0, this.value, this.animationDuration, function () {
				emitProgressBarEvents(self, 'progressCompleted', self.value + '%');
			});
		}
	};

	function updateProgressBar(progressBar, start, to, duration, cb) {
		var change = to - start,
			currentTime = null;

		var animateFill = function (timestamp) {
			if (!currentTime) currentTime = timestamp;
			var progress = timestamp - currentTime;
			var val = parseInt((progress / duration) * change + start);
			// make sure value is in correct range
			if (change > 0 && val > to) val = to;
			if (change < 0 && val < to) val = to;
			if (progress >= duration) val = to;

			setProgressBarValue(progressBar, val);
			if (progress < duration) {
				progressBar.animationId = window.requestAnimationFrame(animateFill);
			} else {
				progressBar.animationId = false;
				cb();
			}
		};
		if (window.requestAnimationFrame && !osHasReducedMotion) {
			progressBar.animationId = window.requestAnimationFrame(animateFill);
		} else {
			setProgressBarValue(progressBar, to);
			cb();
		}
	};

	function setProgressBarValue(progressBar, value) {
		progressBar.fill.style.width = value + '%';
		if (progressBar.label.length > 0) progressBar.label[0].textContent = value + '%';
		if (progressBar.changeColor) updateProgressBarColor(progressBar, value);
	};

	function updateProgressBarColor(progressBar, value) {
		var className = 'progress-bar-fill-color-' + progressBar.colorThresholds.length;
		for (var i = progressBar.colorThresholds.length; i > 0; i--) {
			if (!isNaN(progressBar.colorThresholds[i - 1]) && value <= progressBar.colorThresholds[i - 1]) {
				className = 'progress-bar-fill-color' + i;
			}
		}

		removeProgressBarColorClasses(progressBar);
		Util.addClass(progressBar.element, className);
	};

	function removeProgressBarColorClasses(progressBar) {
		var classes = progressBar.element.className.split(" ").filter(function (c) {
			return c.lastIndexOf('progress-bar-fill-color', 0) !== 0;
		});
		progressBar.element.className = classes.join(" ").trim();
	};

	function emitProgressBarEvents(progressBar, eventName, detail) {
		progressBar.element.dispatchEvent(new CustomEvent(eventName, {
			detail: detail
		}));
	};

	window.ProgressBar = ProgressBar;

	//initialize the ProgressBar objects
	var progressBars = document.getElementsByClassName('progress-bar-custom');
	var osHasReducedMotion = Util.osHasReducedMotion();
	if (progressBars.length > 0) {
		for (var i = 0; i < progressBars.length; i++) {
			(function (i) {
				new ProgressBar(progressBars[i]);
			})(i);
		}
	}
}());

(function () {
	var Tooltip = function (element) {
		this.element = element;
		this.tooltip = false;
		this.tooltipIntervalId = false;
		this.tooltipContent = this.element.getAttribute('title');
		this.tooltipPosition = (this.element.getAttribute('data-tooltip-position')) ? this.element.getAttribute('data-tooltip-position') : 'top';
		this.tooltipClasses = (this.element.getAttribute('data-tooltip-class')) ? this.element.getAttribute('data-tooltip-class') : false;
		this.tooltipId = 'tooltip-element'; // id of the tooltip element -> trigger will have the same aria-describedby attr
		// there are cases where you only need the aria-label -> SR do not need to read the tooltip content (e.g., footnotes)
		this.tooltipDescription = (this.element.getAttribute('data-tooltip-describedby') && this.element.getAttribute('data-tooltip-describedby') == 'false') ? false : true;

		this.tooltipDelay = 300; // show tooltip after a delay (in ms)
		this.tooltipDelta = 10; // distance beetwen tooltip and trigger element (in px)
		this.tooltipTriggerHover = false;
		// tooltp sticky option
		this.tooltipSticky = (this.tooltipClasses && this.tooltipClasses.indexOf('tooltip-sticky') > -1);
		this.tooltipHover = false;
		if (this.tooltipSticky) {
			this.tooltipHoverInterval = false;
		}
		resetTooltipContent(this);
		initTooltip(this);
	};

	function resetTooltipContent(tooltip) {
		var htmlContent = tooltip.element.getAttribute('data-tooltip-title');
		if (htmlContent) {
			tooltip.tooltipContent = htmlContent;
		}
	};

	function initTooltip(tooltipObj) {
		// reset trigger element
		tooltipObj.element.removeAttribute('title');
		tooltipObj.element.setAttribute('tabindex', '0');
		// add event listeners
		tooltipObj.element.addEventListener('mouseenter', handleEvent.bind(tooltipObj));
		tooltipObj.element.addEventListener('focus', handleEvent.bind(tooltipObj));
	};

	function removeTooltipEvents(tooltipObj) {
		// remove event listeners
		tooltipObj.element.removeEventListener('mouseleave', handleEvent.bind(tooltipObj));
		tooltipObj.element.removeEventListener('blur', handleEvent.bind(tooltipObj));
	};

	function handleEvent(event) {
		// handle events
		switch (event.type) {
			case 'mouseenter':
			case 'focus':
				showTooltip(this, event);
				break;
			case 'mouseleave':
			case 'blur':
				checkTooltip(this);
				break;
		}
	};

	function showTooltip(tooltipObj, event) {
		// tooltip has already been triggered
		if (tooltipObj.tooltipIntervalId) return;
		tooltipObj.tooltipTriggerHover = true;
		// listen to close events
		tooltipObj.element.addEventListener('mouseleave', handleEvent.bind(tooltipObj));
		tooltipObj.element.addEventListener('blur', handleEvent.bind(tooltipObj));
		// show tooltip with a delay
		tooltipObj.tooltipIntervalId = setTimeout(function () {
			createTooltip(tooltipObj);
		}, tooltipObj.tooltipDelay);
	};

	function createTooltip(tooltipObj) {
		tooltipObj.tooltip = document.getElementById(tooltipObj.tooltipId);

		if (!tooltipObj.tooltip) { // tooltip element does not yet exist
			tooltipObj.tooltip = document.createElement('div');
			document.body.appendChild(tooltipObj.tooltip);
		}

		// reset tooltip content/position
		Util.setAttributes(tooltipObj.tooltip, {
			'id': tooltipObj.tooltipId,
			'class': 'tooltip tooltip-is-hidden',
			'role': 'tooltip'
		});
		tooltipObj.tooltip.innerHTML = tooltipObj.tooltipContent;
		if (tooltipObj.tooltipDescription) tooltipObj.element.setAttribute('aria-describedby', tooltipObj.tooltipId);
		if (tooltipObj.tooltipClasses) Util.addClass(tooltipObj.tooltip, tooltipObj.tooltipClasses);
		if (tooltipObj.tooltipSticky) Util.addClass(tooltipObj.tooltip, 'tooltip-sticky');
		placeTooltip(tooltipObj);
		Util.removeClass(tooltipObj.tooltip, 'tooltip-is-hidden');

		// if tooltip is sticky, listen to mouse events
		if (!tooltipObj.tooltipSticky) return;
		tooltipObj.tooltip.addEventListener('mouseenter', function cb() {
			tooltipObj.tooltipHover = true;
			if (tooltipObj.tooltipHoverInterval) {
				clearInterval(tooltipObj.tooltipHoverInterval);
				tooltipObj.tooltipHoverInterval = false;
			}
			tooltipObj.tooltip.removeEventListener('mouseenter', cb);
			tooltipLeaveEvent(tooltipObj);
		});
	};

	function tooltipLeaveEvent(tooltipObj) {
		tooltipObj.tooltip.addEventListener('mouseleave', function cb() {
			tooltipObj.tooltipHover = false;
			tooltipObj.tooltip.removeEventListener('mouseleave', cb);
			hideTooltip(tooltipObj);
		});
	};

	function placeTooltip(tooltipObj) {
		// set top and left position of the tooltip according to the data-tooltip-position attr of the trigger
		var dimention = [tooltipObj.tooltip.offsetHeight, tooltipObj.tooltip.offsetWidth],
			positionTrigger = tooltipObj.element.getBoundingClientRect(),
			position = [],
			scrollY = window.scrollY || window.pageYOffset;

		position['top'] = [(positionTrigger.top - dimention[0] - tooltipObj.tooltipDelta + scrollY), (positionTrigger.right / 2 + positionTrigger.left / 2 - dimention[1] / 2)];
		position['bottom'] = [(positionTrigger.bottom + tooltipObj.tooltipDelta + scrollY), (positionTrigger.right / 2 + positionTrigger.left / 2 - dimention[1] / 2)];
		position['left'] = [(positionTrigger.top / 2 + positionTrigger.bottom / 2 - dimention[0] / 2 + scrollY), positionTrigger.left - dimention[1] - tooltipObj.tooltipDelta];
		position['right'] = [(positionTrigger.top / 2 + positionTrigger.bottom / 2 - dimention[0] / 2 + scrollY), positionTrigger.right + tooltipObj.tooltipDelta];

		var direction = tooltipObj.tooltipPosition;
		if (direction == 'top' && position['top'][0] < scrollY) direction = 'bottom';
		else if (direction == 'bottom' && position['bottom'][0] + tooltipObj.tooltipDelta + dimention[0] > scrollY + window.innerHeight) direction = 'top';
		else if (direction == 'left' && position['left'][1] < 0) direction = 'right';
		else if (direction == 'right' && position['right'][1] + dimention[1] > window.innerWidth) direction = 'left';

		if (direction == 'top' || direction == 'bottom') {
			if (position[direction][1] < 0) position[direction][1] = 0;
			if (position[direction][1] + dimention[1] > window.innerWidth) position[direction][1] = window.innerWidth - dimention[1];
		}
		tooltipObj.tooltip.style.top = position[direction][0] + 'px';
		tooltipObj.tooltip.style.left = position[direction][1] + 'px';
		Util.addClass(tooltipObj.tooltip, 'tooltip-' + direction);
	};

	function checkTooltip(tooltipObj) {
		tooltipObj.tooltipTriggerHover = false;
		if (!tooltipObj.tooltipSticky) hideTooltip(tooltipObj);
		else {
			if (tooltipObj.tooltipHover) return;
			if (tooltipObj.tooltipHoverInterval) return;
			tooltipObj.tooltipHoverInterval = setTimeout(function () {
				hideTooltip(tooltipObj);
				tooltipObj.tooltipHoverInterval = false;
			}, 300);
		}
	};

	function hideTooltip(tooltipObj) {
		if (tooltipObj.tooltipHover || tooltipObj.tooltipTriggerHover) return;
		clearInterval(tooltipObj.tooltipIntervalId);
		if (tooltipObj.tooltipHoverInterval) {
			clearInterval(tooltipObj.tooltipHoverInterval);
			tooltipObj.tooltipHoverInterval = false;
		}
		tooltipObj.tooltipIntervalId = false;
		if (!tooltipObj.tooltip) return;
		// hide tooltip
		removeTooltip(tooltipObj);
		// remove events
		removeTooltipEvents(tooltipObj);
	};

	function removeTooltip(tooltipObj) {
		Util.addClass(tooltipObj.tooltip, 'tooltip-is-hidden');
		if (tooltipObj.tooltipDescription) tooltipObj.element.removeAttribute('aria-describedby');
	};

	window.Tooltip = Tooltip;

	//initialize the Tooltip objects
	var tooltips = document.getElementsByClassName('tooltip-trigger');
	if (tooltips.length > 0) {
		for (var i = 0; i < tooltips.length; i++) {
			(function (i) {
				new Tooltip(tooltips[i]);
			})(i);
		}
	}
}());

(function () {
	var FlashMessage = function (element) {
		this.element = element;
		this.showClass = "flash-message-is-visible";
		this.messageDuration = parseInt(this.element.getAttribute('data-duration')) || 3000;
		this.triggers = document.querySelectorAll('[aria-controls="' + this.element.getAttribute('id') + '"]');
		this.temeoutId = null;
		this.isVisible = false;
		this.initFlashMessage();
	};

	FlashMessage.prototype.initFlashMessage = function () {
		var self = this;
		//open modal when clicking on trigger buttons
		if (self.triggers) {
			for (var i = 0; i < self.triggers.length; i++) {
				self.triggers[i].addEventListener('click', function (event) {
					event.preventDefault();
					self.showFlashMessage();
				});
			}
		}
		//listen to the event that triggers the opening of a flash message
		self.element.addEventListener('showFlashMessage', function () {
			self.showFlashMessage();
		});
	};

	FlashMessage.prototype.showFlashMessage = function () {
		var self = this;
		Util.addClass(self.element, self.showClass);
		self.isVisible = true;
		//hide other flash messages
		self.hideOtherFlashMessages();
		if (self.messageDuration > 0) {
			//hide the message after an interveal (this.messageDuration)
			self.temeoutId = setTimeout(function () {
				self.hideFlashMessage();
			}, self.messageDuration);
		}
	};

	FlashMessage.prototype.hideFlashMessage = function () {
		Util.removeClass(this.element, this.showClass);
		this.isVisible = false;
		//reset timeout
		clearTimeout(this.temeoutId);
		this.temeoutId = null;
	};

	FlashMessage.prototype.hideOtherFlashMessages = function () {
		var event = new CustomEvent('flashMessageShown', {
			detail: this.element
		});
		window.dispatchEvent(event);
	};

	FlashMessage.prototype.checkFlashMessage = function (message) {
		if (!this.isVisible) return;
		if (this.element == message) return;
		this.hideFlashMessage();
	};

	//initialize the FlashMessage objects
	var flashMessages = document.getElementsByClassName('flash-message');
	if (flashMessages.length > 0) {
		var flashMessagesArray = [];
		for (var i = 0; i < flashMessages.length; i++) {
			(function (i) {
				flashMessagesArray.push(new FlashMessage(flashMessages[i]));
			})(i);
		}

		//listen for a flash message to be shown -> close the others
		window.addEventListener('flashMessageShown', function (event) {
			flashMessagesArray.forEach(function (element) {
				element.checkFlashMessage(event.detail);
			});
		});
	}
}());

// choice button
(function () {
	var ChoiceButton = function (element) {
		this.element = element;
		this.btns = this.element.getElementsByClassName('choice-btn');
		this.inputs = getChoiceInput(this);
		this.isRadio = this.inputs[0].type.toString() == 'radio';
		resetCheckedStatus(this); // set initial classes
		initChoiceButtonEvent(this); // add listeners
	};

	function getChoiceInput(element) { // store input elements in an object property
		var inputs = [];
		for (var i = 0; i < element.btns.length; i++) {
			inputs.push(element.btns[i].getElementsByTagName('input')[0]);
		}
		return inputs;
	};

	function initChoiceButtonEvent(choiceBtn) {
		choiceBtn.element.addEventListener('click', function (event) { // update status on click
			if (Util.getIndexInArray(choiceBtn.inputs, event.target) > -1) return; // triggered by change in input element -> will be detected by the 'change' event

			var selectedBtn = event.target.closest('.choice-btn');
			if (!selectedBtn) return;
			var index = Util.getIndexInArray(choiceBtn.btns, selectedBtn);
			if (choiceBtn.isRadio && choiceBtn.inputs[index].checked) { // radio input already checked
				choiceBtn.inputs[index].focus(); // move focus to input element
				return;
			}

			choiceBtn.inputs[index].checked = !choiceBtn.inputs[index].checked;
			choiceBtn.inputs[index].dispatchEvent(new CustomEvent('change')); // trigger change event
			choiceBtn.inputs[index].focus(); // move focus to input element
		});

		for (var i = 0; i < choiceBtn.btns.length; i++) {
			(function (i) { // change + focus events
				choiceBtn.inputs[i].addEventListener('change', function (event) {
					choiceBtn.isRadio ? resetCheckedStatus(choiceBtn) : resetSingleStatus(choiceBtn, i);
				});

				choiceBtn.inputs[i].addEventListener('focus', function (event) {
					resetFocusStatus(choiceBtn, i, true);
				});

				choiceBtn.inputs[i].addEventListener('blur', function (event) {
					resetFocusStatus(choiceBtn, i, false);
				});
			})(i);
		}
	};

	function resetCheckedStatus(choiceBtn) {
		for (var i = 0; i < choiceBtn.btns.length; i++) {
			resetSingleStatus(choiceBtn, i);
		}
	};

	function resetSingleStatus(choiceBtn, index) { // toggle .choice-btn--checked class
		Util.toggleClass(choiceBtn.btns[index], 'choice-btn-checked', choiceBtn.inputs[index].checked);
	};

	function resetFocusStatus(choiceBtn, index, bool) { // toggle .choice-btn--focus class
		Util.toggleClass(choiceBtn.btns[index], 'choice-btn-focus', bool);
	};

	//initialize the ChoiceButtons objects
	var choiceButton = document.getElementsByClassName('choice-btns');
	if (choiceButton.length > 0) {
		for (var i = 0; i < choiceButton.length; i++) {
			(function (i) {
				new ChoiceButton(choiceButton[i]);
			})(i);
		}
	};
}());

(function () {
	var ColorSwatches = function (element) {
		this.element = element;
		this.select = false;
		initCustomSelect(this); // replace <select> with custom <ul> list
		this.list = this.element.getElementsByClassName('color-swatches-list')[0];
		this.swatches = this.list.getElementsByClassName('color-swatches-option');
		this.labels = this.list.getElementsByClassName('color-swatch-label');
		this.selectedLabel = this.element.getElementsByClassName('color-swatches-color');
		this.focusOutId = false;
		initColorSwatches(this);
	};

	function initCustomSelect(element) {
		var select = element.element.getElementsByClassName('color-swatches-select');
		if (select.length == 0) return;
		element.select = select[0];
		var customContent = '';
		for (var i = 0; i < element.select.options.length; i++) {
			var ariaChecked = i == element.select.selectedIndex ? 'true' : 'false',
				customClass = i == element.select.selectedIndex ? ' color-swatches-item-selected' : '',
				customAttributes = getSwatchCustomAttr(element.select.options[i]);
			customContent = customContent + '<li class="color-swatches-item color-swatches-item' + customClass + '" role="radio" aria-checked="' + ariaChecked + '" data-value="' + element.select.options[i].value + '"><span class="color-swatches-option tab-focus" tabindex="0"' + customAttributes + '><span class="sr-only color-swatch-label">' + element.select.options[i].text + '</span><span aria-hidden="true" style="' + element.select.options[i].getAttribute('data-style') + '" class="color-swatches-swatch"></span></span></li>';
		}

		var list = document.createElement("ul");
		Util.setAttributes(list, {
			'class': 'color-swatches-list color-swatches-list',
			'role': 'radiogroup'
		});

		list.innerHTML = customContent;
		element.element.insertBefore(list, element.select);
		Util.addClass(element.select, 'is-hidden');
	};

	function initColorSwatches(element) {
		// detect focusin/focusout event - update selected color label
		element.list.addEventListener('focusin', function (event) {
			if (element.focusOutId) clearTimeout(element.focusOutId);
			updateSelectedLabel(element, document.activeElement);
		});
		element.list.addEventListener('focusout', function (event) {
			element.focusOutId = setTimeout(function () {
				resetSelectedLabel(element);
			}, 200);
		});

		// mouse move events
		for (var i = 0; i < element.swatches.length; i++) {
			handleHoverEvents(element, i);
		}

		// --select variation only
		if (element.select) {
			// click event - select new option
			element.list.addEventListener('click', function (event) {
				// update selected option
				resetSelectedOption(element, event.target);
			});

			// space key - select new option
			element.list.addEventListener('keydown', function (event) {
				if ((event.keyCode && event.keyCode == 32 || event.key && event.key == ' ') || (event.keyCode && event.keyCode == 13 || event.key && event.key.toLowerCase() == 'enter')) {
					// update selected option
					resetSelectedOption(element, event.target);
				}
			});
		}
	};

	function handleHoverEvents(element, index) {
		element.swatches[index].addEventListener('mouseenter', function (event) {
			updateSelectedLabel(element, element.swatches[index]);
		});
		element.swatches[index].addEventListener('mouseleave', function (event) {
			resetSelectedLabel(element);
		});
	};

	function resetSelectedOption(element, target) { // for --select variation only - new option selected
		var option = target.closest('.color-swatches-item');
		if (!option) return;
		var selectedSwatch = element.list.querySelector('.color-swatches-item-selected');
		if (selectedSwatch) {
			Util.removeClass(selectedSwatch, 'color-swatches-item-selected');
			selectedSwatch.setAttribute('aria-checked', 'false');
		}
		Util.addClass(option, 'color-swatches-item-selected');
		option.setAttribute('aria-checked', 'true');
		// update select element
		updateNativeSelect(element.select, option.getAttribute('data-value'));
	};

	function resetSelectedLabel(element) {
		var selectedSwatch = element.list.getElementsByClassName('color-swatches-item-selected');
		if (selectedSwatch.length > 0) updateSelectedLabel(element, selectedSwatch[0]);
	};

	function updateSelectedLabel(element, swatch) {
		var newLabel = swatch.getElementsByClassName('color-swatch-label');
		if (newLabel.length == 0) return;
		element.selectedLabel[0].textContent = newLabel[0].textContent;
	};

	function updateNativeSelect(select, value) {
		for (var i = 0; i < select.options.length; i++) {
			if (select.options[i].value == value) {
				select.selectedIndex = i; // set new value
				select.dispatchEvent(new CustomEvent('change')); // trigger change event
				break;
			}
		}
	};

	function getSwatchCustomAttr(swatch) {
		var customAttrArray = swatch.getAttribute('data-custom-attr');
		if (!customAttrArray) return '';
		var customAttr = ' ',
			list = customAttrArray.split(',');
		for (var i = 0; i < list.length; i++) {
			var attr = list[i].split(':')
			customAttr = customAttr + attr[0].trim() + '="' + attr[1].trim() + '" ';
		}
		return customAttr;
	};

	//initialize the ColorSwatches objects
	var swatches = document.getElementsByClassName('color-swatches');
	if (swatches.length > 0) {
		for (var i = 0; i < swatches.length; i++) {
			new ColorSwatches(swatches[i]);
		}
	}
}());

// footnotes
(function () {
	var Footnote = function (element) {
		this.element = element;
		this.link = this.element.getElementsByClassName('footnotes-back-link')[0];
		this.contentLink = document.getElementById(this.link.getAttribute('href').replace('#', ''));
		this.initFootnote();
	};

	Footnote.prototype.initFootnote = function () {
		Util.setAttributes(this.contentLink, {
			'aria-label': 'Footnote: ' + this.element.getElementsByClassName('footnote-label')[0].textContent,
			'data-tooltip-class': 'tooltip-lg tooltip-sticky',
			'data-tooltip-describedby': 'false',
			'title': this.getFootnoteContent(),
		});
		new Tooltip(this.contentLink);
	};

	Footnote.prototype.getFootnoteContent = function () {
		var clone = this.element.cloneNode(true);
		clone.removeChild(clone.getElementsByClassName('footnotes-back-link')[0]);
		return clone.innerHTML;
	};

	var footnotes = document.getElementsByClassName('footnotes-item');
	if (footnotes.length > 0) {
		for (var i = 0; i < footnotes.length; i++) {
			(function (i) {
				new Footnote(footnotes[i]);
			})(i);
		}
	}
}());

// notice
(function () {
	function initNoticeEvents(notice) {
		notice.addEventListener('click', function (event) {
			if (event.target.closest('.notice-hide-control')) {
				event.preventDefault();
				Util.addClass(notice, 'notice-hide');
			}
		});
	};

	var noticeElements = document.getElementsByClassName('notice');
	if (noticeElements.length > 0) {
		for (var i = 0; i < noticeElements.length; i++) {
			(function (i) {
				initNoticeEvents(noticeElements[i]);
			})(i);
		}
	}
}());

// button states
$('.btn-states').on('click', function (e) {
	e.preventDefault();
	$(this).toggleClass('btn-state-b');
});

$(function () {
	'use strict'
	feather.replace();

	ReadMore();
	SmoothScroll();
	showPassword();
});

$(document).ready(function () {
	$('.btn-fillloader').on('click', function (e) {
		e.preventDefault();
		var $timeOutLoader = $(this).attr('data-timeout') || 1000;
		var $setLoader = $(this).addClass('animate');
		setTimeout(function () {
			$setLoader.removeClass('animate');
		}, $timeOutLoader);
	});

	$('.form-control-col').focus(function () {
		$(this).parent('.input-merger').addClass('focus');
	}).blur(function () {
		$(this).parent('.input-merger').removeClass('focus');
	});

	// modal effect slide + zoom
	$('.modal[class*="slide-"], .modal[class*="zoom-"]').on('shown.bs.modal', function (e) {
		$('.modal-backdrop').remove();
	});
	$('.modal[class*="slide-"], .modal[class*="zoom-"]').on('hidden.bs.modal', function (e) {
		$(this).removeAttr('style');
	});
});
