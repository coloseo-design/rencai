var isMobile = {
	Android: function() {
		return navigator.userAgent.match(/Android/i);
	},
	iOS: function() {
		return navigator.userAgent.match(/iPhone|iPad|iPod/i);
	},
	safari: function() {
		return navigator.userAgent.toLowerCase().indexOf('safari/') > -1 && navigator.userAgent.toLowerCase().indexOf('chrome/') === -1;
	},
	PC: function() {

	}
};

var isWebRTCSupported = false;
['RTCPeerConnection', 'webkitRTCPeerConnection', 'mozRTCPeerConnection', 'RTCIceGatherer'].forEach(function(item) {
	if (isWebRTCSupported) {
		return;
	}
	if (item in window) {
		isWebRTCSupported = true;
	}
});

function startBrowserTest() {

	var sys = getSystemInfo();
	if (sys.browserName == 'IE' || sys.browserName == 'Firefox') {
		// IE和Firefox不支持
		return false;
	} else if (sys.browserName == 'Chrome' && parseInt(sys.browserVersion) < 56) {
		// Chrome 56+
		return false;
	} else if (sys.browserName == 'Safari' && parseInt(sys.browserVersion) < 11) {
		// Safari 11+
		return false;
	} else if(navigator.userAgent.indexOf('baiduappbox') > -1){
		// 百度APP
		return false;
	}

	var isSupport = true;
	var isMobileBrowser = false;
	for (var a in isMobile) {
		if (isMobile[a]()) {
			isMobileBrowser = true
			var version = checkTBSVersion(navigator.userAgent);
			if (a === 'Android' && version && version < 43600) {
				isSupport = false;
			} else if (!isWebRTCSupported || (!isMobile.safari() && isMobile.iOS())) {
				isSupport = false;
			} else {
				if (isMobile.safari() && isMobile.iOS()) {
					//ios 11 版本 11.0.3 以下不支持
					var matches = (navigator.userAgent).match(/OS (\d+)_(\d+)_?(\d+)?/);
					if (matches && matches[1] >= 11 && (matches[2] >= 1 || matches[3] >= 3)) {
						isSupport = true;
					} else {
						isSupport = false;
					}
				} else {
					isSupport = true;
				}
			}
			break;
		}
	}
	if (isWebRTCSupported) {
		checkH264Support(function(encode, decode) {
			isSupport = false;
			if (!encode || !decode) {
				isWebRTCSupported = false;
			}
			if (!isMobileBrowser) {
				if (isWebRTCSupported) {
					isSupport = true;
				}
			}
		});
	}

	return isSupport;
}

function checkTBSVersion(ua) {
	var list = ua.split(" ");
	for (var i = 0; i < list.length; i++) {
		var item = list[i];
		if (item.indexOf("TBS") !== -1 || item.indexOf("tbs") !== -1) {
			var versionStr = item.split("/")[1];
			var version = parseInt(versionStr) || 0;
			return version
		}
	}
	return null;
}

function checkH264Support(callback) {
	try {
		var peer = new RTCPeerConnection(null);
		var decode = checkH264DecodeSupport()
		peer.createOffer({
			offerToReceiveAudio: 1,
			offerToReceiveVideo: 1
		}).then(function(data) {
			var encode = data.sdp.toLowerCase().indexOf("h264") !== -1
			callback(encode, decode)
			peer.close();
		}, function(data) {
			callback(false, decode)
		});
	} catch (err) {
		callback(false, false);
	}
}

function checkH264DecodeSupport() {
	var element = document.createElement('video')
	return !!element.canPlayType && (canPlayType(element, 'video/mp4; codecs="avc1.42E01E"') || canPlayType(element,
		'video/mp4; codecs="avc1.42E01E, mp4a.40.2"'))
}
var canPlayType = function(element, type) {
	return element.canPlayType(type) == 'probably';
};

function getSystemInfo() {
	var agent = navigator.userAgent;
	var browserName = navigator.appName;
	var version = '' + parseFloat(navigator.appVersion);
	var offsetName;
	var offsetVersion;
	var ix;

	if ((offsetVersion = agent.indexOf('Chrome')) !== -1) {
		browserName = 'Chrome';
		version = agent.substring(offsetVersion + 7);
	} else if ((offsetVersion = agent.indexOf('MSIE')) !== -1) {
		browserName = 'IE'; // Older IE versions.
		version = agent.substring(offsetVersion + 5);
	} else if ((offsetVersion = agent.indexOf('Trident')) !== -1) {
		browserName = 'IE'; // Newer IE versions.
		version = agent.substring(offsetVersion + 8);
	} else if ((offsetVersion = agent.indexOf('Firefox')) !== -1) {
		browserName = 'Firefox';
	} else if ((offsetVersion = agent.indexOf('Safari')) !== -1) {
		browserName = 'Safari';
		version = agent.substring(offsetVersion + 7);
		if ((offsetVersion = agent.indexOf('Version')) !== -1) {
			version = agent.substring(offsetVersion + 8);
		}
	} else if ((offsetName = agent.lastIndexOf(' ') + 1) <
		(offsetVersion = agent.lastIndexOf('/'))) {
		browserName = agent.substring(offsetName, offsetVersion);
		version = agent.substring(offsetVersion + 1);
		if (browserName.toLowerCase() === browserName.toUpperCase()) {
			browserName = navigator.appName;
		}
	}
	if ((ix = version.indexOf(';')) !== -1) {
		version = version.substring(0, ix);
	}
	if ((ix = version.indexOf(' ')) !== -1) {
		version = version.substring(0, ix);
	}
	return {
		'browserName': browserName,
		'browserVersion': version,
		'platform': navigator.platform
	};
}
//使用requestAnimationFrame重写setInterval，进行性能优化
function setAnimationFrame(render) {
	// 计时器ID
	let timer = {};

	function animeLoop() {
		render();
		timer.id = requestAnimationFrame(animeLoop);
	}
	animeLoop();
	return timer;
}

// 清除AnimationFrame
function clearAnimationFrame(timer) {
	cancelAnimationFrame(timer.id);
}
