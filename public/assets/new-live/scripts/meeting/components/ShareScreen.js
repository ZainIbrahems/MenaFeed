import { VideosList } from "./VideosList.js";
import { Whiteboard } from "./Whiteboard.js";
import { Swiper as SwiperComponent } from "./Swiper.js";

let videosSection = document.querySelector("#videos_section");

const ShareOptions = () => {
  videosSection.innerHTML = `
     <div class="share_options">
    <div class="share_header">
      <h4>Share Options</h4>
      <img src="./icons/cancel.svg" width="15" height="15" alt="" />
    </div>

    <div class="share_list">
      <p>Who can share?</p>
      <ul>
        <button
          style="
            border: 1px solid black;
            background-color: white;
            color: black;
          "
        >
          Host Only
        </button>
        <button
          style="
            border: 1px solid #2688eb;
            background-color: #2688eb;
            color: white;
          "
        >
          All Participants
        </button>
      </ul>
    </div>
    <div class="share_list">
      <p>Who can start sharing when someone else is sharing?</p>
      <ul>
        <button
          style="
            border: 1px solid #2688eb;
            background-color: #2688eb;
            color: white;
          "
        >
          Host Only
        </button>
        <button
          style="
            border: 1px solid black;
            background-color: white;
            color: black;
          "
        >
          All Participants
        </button>
      </ul>
    </div>
  </div>
    `;
};

document.querySelector("#share_screen_button").addEventListener("click", () => {
  ShareOptions();
  displayShareScreen();
});

function displayShareScreen() {
  document.querySelector(".share_options").addEventListener("click", () => {
    ShareScreen({ resize: false, stateStr: "share_screen" });
  });
}

const VideoItem = ({ video, fullscreen }) => {
  const { name, video: videoContent, image, isMute } = video;

  let content = null;
  let contentSize = "25";
  if (fullscreen) contentSize = "75";

  content = `<img
        src="${image ? image : "./images/user-image.png"}"
        width=${contentSize}
        height=${contentSize}
        style="width: ${contentSize}px; height: ${contentSize}px;"
        class=${fullscreen ? "" : "no_image"}
        alt=""
        />`;

  return `
        <div class="video_item ${fullscreen ? "" : "swiper-slide"}" style="${
    videoContent ? `background-image: url(${videoContent});` : ""
  } ${!isMute ? "border: 3px solid #2688EB;" : ""} ${
    fullscreen
      ? "width: 100%; max-block-size: fit-content; flex: 1;"
      : "min-width: 150px; width: 150px !important; max-width: 150px !important; height: 100px;"
  }">
             ${!videoContent ? content : ""}
            <div>
            <img src=${
              isMute
                ? "./icons/mic-muted-full-white.svg"
                : "./icons/mic-full-white.svg"
            } width="15px" height="15px" alt="" />
            <p>${name}</p>
            </div>
        </div>
        `;
};

let state = null;

export const ShareScreen = ({ resize, stateStr }) => {

  if(stateStr) {
    state = stateStr
  }

  console.log(state, stateStr)

  const screenWidth = window.screen.width;
  let size = 7;

  if (screenWidth <= 1250) {
    size = 5;
  }

  if (screenWidth <= 750) {
    size = 3;
  }

  if (screenWidth <= 500) {
    size = 2;
  }

  let pages = [];

  for (let i = 0; i < list.length; i += size) {
    pages.push(list.slice(i, i + size));
  }

  if (!resize) {
    document.querySelector("#swiperSection").innerHTML = SwiperComponent();
  }

  let videosSection = document.querySelector("#videos_section");
  let swiper = document.querySelector(".swiper-container");
  let wrapper = document.querySelector(".swiper-wrapper");

  wrapper.innerHTML = `
  ${pages
    .map(
      (array) =>
        `
      <ul class="share_screen_list swiper-slide" style="width: 100%">
      ${array.map((item) => VideoItem({ video: item, fullscreen: false }))}
      </ul>
    `
    )
    .join("")}
    `;

  videosSection.innerHTML = `
        <div class="share_screen">
        <div class="swiper-container" style="width: 100%; margin: auto; overflow-x: hidden; position: relative;"
        >
        ${swiper.innerHTML}
        </div>
                
                 ${
                   state === "share_screen"
                     ? VideoItem({ video: list[1], fullscreen: true })
                     : Whiteboard()
                 }
        </div>
    `;

  if (state === "share_screen") {
    document.querySelector(
      "#share_screen_button"
    ).firstElementChild.style.backgroundColor = "#2688EB";
    document.querySelector("#share_screen_button").style.color = "#2688EB";
  } else if (state === "whiteboard") {
    document.querySelector(
      "#whiteboard_button"
    ).firstElementChild.style.backgroundColor = "#2688EB";

    document
      .querySelector("#whiteboard_button")
      .querySelector("p").style.color = "#2688EB";
  }

  document.querySelector("#swiperSection").innerHTML = null;

  new Swiper(".swiper-container", {
    // Optional parameters
    direction: "horizontal",
    loop: false,
    slidesPerView: "auto",

    // Navigation arrows
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
  });
};

const list = [
  {
    name: "jim",
    video: null,
    image: null,
    isMute: true,
  },
  {
    name: "mira",
    video: "./images/image31.png",
    image: null,
    isMute: false,
  },
  {
    name: "ahmed",
    video: "./images/image32.png",
    image: null,
    isMute: true,
  },
  {
    name: "nora",
    video: null,
    image: "./images/Ellipse 96.png",
    isMute: true,
  },
  {
    name: "jim",
    video: null,
    image: null,
    isMute: true,
  },
  {
    name: "mira",
    video: "./images/image31.png",
    image: null,
    isMute: false,
  },
  {
    name: "ahmed",
    video: "./images/image32.png",
    image: null,
    isMute: true,
  },
  {
    name: "nora",
    video: null,
    image: "./images/Ellipse 96.png",
    isMute: true,
  },
  {
    name: "jim",
    video: null,
    image: null,
    isMute: true,
  },
  {
    name: "mira",
    video: "./images/image31.png",
    image: null,
    isMute: false,
  },
  {
    name: "ahmed",
    video: "./images/image32.png",
    image: null,
    isMute: true,
  },
  {
    name: "nora",
    video: null,
    image: "./images/Ellipse 96.png",
    isMute: true,
  },
  {
    name: "jim",
    video: null,
    image: null,
    isMute: true,
  },
  {
    name: "mira",
    video: "./images/image31.png",
    image: null,
    isMute: false,
  },
  {
    name: "ahmed",
    video: "./images/image32.png",
    image: null,
    isMute: true,
  },
  {
    name: "nora",
    video: null,
    image: "./images/Ellipse 96.png",
    isMute: true,
  },
  {
    name: "jim",
    video: null,
    image: null,
    isMute: true,
  },
  {
    name: "mira",
    video: "./images/image31.png",
    image: null,
    isMute: false,
  },
  {
    name: "ahmed",
    video: "./images/image32.png",
    image: null,
    isMute: true,
  },
  {
    name: "nora",
    video: null,
    image: "./images/Ellipse 96.png",
    isMute: true,
  },
  {
    name: "jim",
    video: null,
    image: null,
    isMute: true,
  },
  {
    name: "mira",
    video: "./images/image31.png",
    image: null,
    isMute: false,
  },
  {
    name: "ahmed",
    video: "./images/image32.png",
    image: null,
    isMute: true,
  },
  {
    name: "nora",
    video: null,
    image: "./images/Ellipse 96.png",
    isMute: true,
  },
  {
    name: "jim",
    video: null,
    image: null,
    isMute: true,
  },
  {
    name: "mira",
    video: "./images/image31.png",
    image: null,
    isMute: false,
  },
  {
    name: "ahmed",
    video: "./images/image32.png",
    image: null,
    isMute: true,
  },
  {
    name: "nora",
    video: null,
    image: "./images/Ellipse 96.png",
    isMute: true,
  },
  {
    name: "jim",
    video: null,
    image: null,
    isMute: true,
  },
  {
    name: "mira",
    video: "./images/image31.png",
    image: null,
    isMute: false,
  },
  {
    name: "ahmed",
    video: "./images/image32.png",
    image: null,
    isMute: true,
  },
  {
    name: "nora",
    video: null,
    image: "./images/Ellipse 96.png",
    isMute: true,
  },
  {
    name: "jim",
    video: null,
    image: null,
    isMute: true,
  },
  {
    name: "mira",
    video: "./images/image31.png",
    image: null,
    isMute: false,
  },
  {
    name: "ahmed",
    video: "./images/image32.png",
    image: null,
    isMute: true,
  },
  {
    name: "nora",
    video: null,
    image: "./images/Ellipse 96.png",
    isMute: true,
  },
  {
    name: "nora",
    video: null,
    image: "./images/Ellipse 96.png",
    isMute: true,
  },
];
