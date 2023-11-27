let listAttach = document.querySelector("#list-attach");
let listFullScreen = document.querySelector("#list-fullscreen");
let listOptions = document.querySelector("#list-options");

let chatButton = document.querySelector(".chat-button");
let participantsButton = document.querySelector(".participants-button");
let participant = document.querySelector(".participant");
let participantOptions = document.querySelector(".participant-options");
let chatElement = document.querySelector(".chat-element");
let addParticipantButton = document.querySelector("#add-participant-button");
let typeMessageSegment = document.querySelector(".type-message-segment");

let listMic = document.querySelector("#list-mic");
let videoMic = document.querySelector(".video-mic");
let singleVideoMic = document.querySelector(".single-video-mic");
let listVideo = document.querySelector("#list-video");
let participantList = document.querySelector(".participant-list");
let singleVideoImage = document.querySelector(".single-video-image");
let noImageVideo = document.querySelector(".no-image-video");
let startRecordButton = document.querySelector("#start-record-button");
let goLiveButton = document.querySelector("#go-live-button");
let leaveStudioButton = document.querySelector("#leave-studio-button");
let endRecordAlert = document.querySelector(".end-record-alert");
let endRecordButton = document.querySelector("#end-record-button");
let cancelEndRecord = document.querySelector("#cancel-end-record");
let leftStreamAlert = document.querySelector(".left-stream-alert");
let rejoinButton = document.querySelector("#rejoin-button");
let fullScreenButton = document.querySelector("#list-fullscreen");
let videoList = document.querySelector(".video-list");
let optionsList = document.querySelector(".options-list");
let video = document.querySelector(".video");
let mainList = document.querySelector(".main-list");
let videoOptionsList = document.querySelector(".video-options-list");
let streamMode = document.querySelector("#data");
let streamVideo = document.querySelector("#stream-video");
let dataElement = document.querySelector("#data");
let streamDetails = document.querySelector(".stream-details");
let cancelChatButton = document.querySelector("#cancel-chat-button");
let chat = document.querySelector(".chat");
let mainVideo = document.querySelector(".main-video.single-video-image")
let listVideoSegment = document.querySelector(".list-video-segment")

const toggleMic = () => {
  if (listMic.src.includes("mic-muted-white.svg")) {
    listMic.src = "./icons/mic-white.svg";
    listMic.style.backgroundColor = "#01BC62";
    videoMic.style.display = "none";
    singleVideoMic.style.display = "none"
  } else {
    listMic.src = "./icons/mic-muted-white.svg";
    listMic.style.backgroundColor = "#A3A3A3";
    videoMic.style.display = "block";
    singleVideoMic.style.display = "block";
  }
};

if (listMic) {
    listMic.addEventListener("click", toggleMic);
}

if (videoMic) {
  videoMic.addEventListener("click", toggleMic);
}

if(singleVideoMic) {
  singleVideoMic.addEventListener("click", toggleMic)
}

if (listVideo) {
  listVideo.addEventListener("click", () => {
    if (listVideo.src.includes("video-white.svg")) {
      listVideo.src = "./icons/video-disabled-white.svg";
      listVideo.style.backgroundColor = "#A3A3A3";
      noImageVideo.style.display = "flex";
      singleVideoImage.style.display = "none";
    } else {
      listVideo.src = "./icons/video-white.svg";
      listVideo.style.backgroundColor = "#01BC62";
      noImageVideo.style.display = "none";
      singleVideoImage.style.display = "block";
    }
  });
}

if (chatButton) {
  chatButton.addEventListener("click", () => {
    chatElement.style.display = "flex";
    typeMessageSegment.style.display = "flex";
    participant.style.display = "none";
    addParticipantButton.style.display = "none";

    chatButton.style.backgroundColor = "#2688EB";
    chatButton.style.color = "white";
    participantsButton.style.backgroundColor = "white";
    participantsButton.style.color = "#2688EB";
    participantsButton.style.border = "1px solid #2688EB";
    participantsButton.childNodes[3].style.backgroundColor =
      "rgba(51, 182, 255, 0.2)";
  });
}

if (participantsButton) {
  participantsButton.addEventListener("click", () => {
    chatElement.style.display = "none";
    typeMessageSegment.style.display = "none";
    participant.style.display = "flex";
    addParticipantButton.style.display = "block";

    participantsButton.style.backgroundColor = "#2688EB";
    participantsButton.style.color = "white";
    participantsButton.childNodes[3].style.backgroundColor = "white";
    chatButton.style.backgroundColor = "white";
    chatButton.style.color = "#2688EB";
    chatButton.style.border = "1px solid #2688EB";
  });
}

participantList.childNodes[5].addEventListener("click", () => {
  if (
    !participantOptions.style.display ||
    participantOptions.style.display === "none"
  ) {
    participantOptions.style.display = "flex";
  } else {
    participantOptions.style.display = "none";
  }
});

if (participantList.childNodes[1]) {
  participantList.childNodes[1].addEventListener("click", () => {
    if (participantList.childNodes[1].src.includes("mic-muted-red")) {
      participantList.childNodes[1].src = "./icons/mic-blue.svg";
    } else {
      participantList.childNodes[1].src = "./icons/mic-muted-red.svg";
    }
  });
}

if (participantList.childNodes[3]) {
  participantList.childNodes[3].addEventListener("click", () => {
    if (participantList.childNodes[3].src.includes("video-disabled-red")) {
      participantList.childNodes[3].src = "./icons/video-blue.svg";
    } else {
      participantList.childNodes[3].src = "./icons/video-disabled-red.svg";
    }
  });
}

if (startRecordButton) {
  startRecordButton.addEventListener("click", () => {
    if (startRecordButton.childNodes[3].innerHTML === "Start Recording") {
      startRecordButton.childNodes[3].innerHTML = "End Recording";
      startRecordButton.childNodes[1].src = "./icons/end-record.svg";
      startRecordButton.style.border = "4px solid rgba(227, 0, 0, 0.5)";
      startRecordButton.style.backgroundColor = "inherit";
      startRecordButton.style.color = "#E64646";
    } else {
      startRecordButton.childNodes[3].innerHTML = "Start Recording";
      startRecordButton.childNodes[1].src = "./icons/start-record.svg";
      startRecordButton.style.color = "white";
      startRecordButton.style.backgroundColor = "#475366";
      startRecordButton.style.border = "4px solid #475366";
    }
  });
}

if (goLiveButton) {
  goLiveButton.addEventListener("click", () => {
    if (goLiveButton.childNodes[3].innerHTML === "Go Live") {
      goLiveButton.childNodes[3].innerHTML = "Pause Live";
      goLiveButton.childNodes[1].src = "./icons/pause.svg";
    } else {
      goLiveButton.childNodes[3].innerHTML = "Go Live";
      goLiveButton.childNodes[1].src = "./icons/stream.svg";
    }
  });
}

if (leaveStudioButton) {
  leaveStudioButton.addEventListener("click", () => {
    endRecordAlert.style.display = "flex";
    document.body.style.overflow = "hidden";
  });
}

if (cancelEndRecord) {
  cancelEndRecord.addEventListener("click", () => {
    document.body.style.overflow = "auto";
    endRecordAlert.style.display = "none";
    leftStreamAlert.style.display = "none";
  });
}

if (endRecordButton) {
  endRecordButton.addEventListener("click", () => {
    endRecordAlert.style.display = "none";
    leftStreamAlert.style.display = "flex";
  });
}

if (rejoinButton) {
  rejoinButton.addEventListener("click", () => {
    leftStreamAlert.style.display = "none";
    document.body.style.overflow = "auto";
  });
}

if (fullScreenButton) {
  fullScreenButton.addEventListener("click", () => {
    if (fullScreenButton.getAttribute("fullscreen") === "true") {
      if (document.exitFullscreen) {
        document.exitFullscreen();
      } else if (document.webkitExitFullscreen) {
        /* Safari */
        document.webkitExitFullscreen();
      } else if (document.msExitFullscreen) {
        /* IE11 */
        document.msExitFullscreen();
      }
    } else {
      fullScreenButton.setAttribute("fullscreen", "true");
      video.insertBefore(optionsList, videoList);
      video.appendChild(videoOptionsList);

      videoList.style.maxHeight = "100%"
      mainVideo.style.maxHeight = "100%"
      video.style.position = "relative";
      videoOptionsList.classList.toggle("full-screen-video-options-list");
      optionsList.classList.toggle("full-screen-options-list");
      optionsList.classList.toggle("options-list");
      optionsList.childNodes[7].style.display = "none";
      optionsList.childNodes[1].childNodes[3].style.display = "none";
      optionsList.childNodes[3].childNodes[3].style.display = "none";
      optionsList.childNodes[5].childNodes[3].style.display = "none";
      video.appendChild(endRecordAlert);
      video.appendChild(leftStreamAlert);
      if (document.querySelector(".video-segment")) {
        document.querySelector(".video-segment").style.height = "100%";
        document.querySelector(".video-segment").style.borderRadius = "0";
      }
      if (video.requestFullscreen) {
        video.requestFullscreen();
      } else if (video.webkitRequestFullscreen) {
        /* Safari */
        video.webkitRequestFullscreen();
      } else if (video.msRequestFullscreen) {
        /* IE11 */
        video.msRequestFullscreen();
      }
    }
  });
}

if (document.addEventListener) {
  document.addEventListener("fullscreenchange", exitHandler, false);
  document.addEventListener("mozfullscreenchange", exitHandler, false);
  document.addEventListener("MSFullscreenChange", exitHandler, false);
  document.addEventListener("webkitfullscreenchange", exitHandler, false);
}

function exitHandler() {
  if (
    !document.webkitIsFullScreen &&
    !document.mozFullScreen &&
    !document.msFullscreenElement
  ) {
    fullScreenButton.setAttribute("fullscreen", "false");
    console.log("exit");
    mainList.appendChild(optionsList);

    mainVideo.style.maxHeight = ""
    video.style.position = ""
    videoOptionsList.classList.toggle("full-screen-video-options-list");
    optionsList.classList.toggle("full-screen-options-list");
    optionsList.classList.toggle("options-list");
    optionsList.childNodes[7].style.display = "flex";
    optionsList.childNodes[1].childNodes[3].style.display = "block";
    optionsList.childNodes[3].childNodes[3].style.display = "block";
    optionsList.childNodes[5].childNodes[3].style.display = "block";
  }
}

if (streamVideo) {
  streamVideo.style.display = "none";
}

if (addParticipantButton) {
  addParticipantButton.addEventListener("click", () => {
    if (dataElement && dataElement.getAttribute("stream-mode") === "single") {
      dataElement.setAttribute("stream-mode", "multiple");
      streamVideo.style.display = "none";
      videoList.style.display = "";
    } else {
      dataElement.setAttribute("stream-mode", "single");
      streamVideo.style.display = "";
      videoList.style.display = "none";
    }
  });
}

if (streamDetails) {
  streamDetails.addEventListener("click", () => {
    console.log("click", screen.width);
    if (screen.width < 768) {
      chat.style.display = "flex";
    }
  });
}

if (cancelChatButton) {
  cancelChatButton.addEventListener("click", () => {
    if (screen.width < 768) {
      chat.style.display = "";
    }
  });
}
