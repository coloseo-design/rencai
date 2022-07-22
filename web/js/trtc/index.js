// v4.7.0 及其以上版本的 SDK
TRTC.checkSystemRequirements().then((checkResult) => {
  if(!checkResult.result) {
     unUserd();
     // SDK 不支持当前浏览器，根据用户设备类型建议用户使用 SDK 支持的浏览器
  }else{
      // 设备不支持H.264
      let checkDetail = checkResult.detail;
      if(!checkDetail.isH264DecodeSupported || !checkDetail.isH264EncodeSupported ){
         unUserd(); 
      }
  }
});
// setup logging stuffs
TRTC.Logger.setLogLevel(TRTC.Logger.LogLevel.WARN);
TRTC.Logger.enableUploadLog();

TRTC.getDevices()
  .then(devices => {
    devices.forEach(item => {
      //console.log('device: ' + item.kind + ' ' + item.label + ' ' + item.deviceId);
    });
  })
  .catch(error => console.error('getDevices error observed ' + error));

// populate camera options
TRTC.getCameras().then(devices => {
  devices.forEach(device => {
    if (!cameraId) {
      cameraId = device.deviceId;
    }
  });
});

// populate microphone options
TRTC.getMicrophones().then(devices => {
  devices.forEach(device => {
    if (!micId) {
      micId = device.deviceId;
    }
  });
});