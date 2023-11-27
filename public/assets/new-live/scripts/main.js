const containerWithImage = document.querySelector("#container-with-image")

if (containerWithImage) {
    containerWithImage.style.display = "none"
}


const toggleMic = () => {
    if (listMic.src.includes("mic-white.svg")) {
        listMic.src = url + "/assets/new-live/icons/mic-muted-white.svg";
        listMic.style.backgroundColor = "#A3A3A3";
        videoMic.style.display = "block";
        videoWithImageMic.style.display = "block";
        $('#togglemic').prop('checked', false);
    } else {
        listMic.src = url + "/assets/new-live/icons/mic-white.svg";
        listMic.style.backgroundColor = "#01BC62";
        videoMic.style.display = "none";
        videoWithImageMic.style.display = "none";
        $('#togglemic').prop('checked', true);
    }
}

const videoWithImageMic = document.querySelector("#video-with-image-mic")

if (videoWithImageMic) {
    videoWithImageMic.addEventListener("click", toggleMic);
}

const videoMic = document.querySelector("#video-mic");
if (videoMic) {
    videoMic.addEventListener("click", toggleMic);
}

const listMic = document.querySelector("#list-mic");
if (listMic) {
    listMic.addEventListener("click", toggleMic);
}

const mainContainerImage = document.querySelector(".main-container-image")

const listVideo = document.querySelector("#list-video");
$('#muteCamera').prop('checked', false);
if (listVideo) {
    listVideo.addEventListener("click", () => {
        if (listVideo.src.includes("video-white.svg")) {
            listVideo.src = url + "/assets/new-live/icons/video-disabled-white.svg";
            listVideo.style.backgroundColor = "#A3A3A3";
            containerWithImage.style.display = "none";
            mainContainerImage.style.display = "";
            $('#muteCamera').prop('checked', false);
        } else {
            listVideo.src = url + "/assets/new-live/icons/video-white.svg";
            listVideo.style.backgroundColor = "#01BC62";
            containerWithImage.style.display = "";
            mainContainerImage.style.display = "none";
            $('#muteCamera').prop('checked', true);
        }
    });
}



