import { Swiper as SwiperComponent } from "./Swiper.js";

const VideoItem = ({ video, fullscreen }) => {
  const { name, video: videoContent, image, isMute } = video;

  let content = null;
  content = `<img
        src="${image ? image : "./images/user-image.png"}"
        width="75px"
        height="75px"
        style="width: 75px; height: 75px; position: static; transform: none"
        class="no_image"
        alt=""
        />`;

  return `
        <div class="video_item" style="${
          videoContent ? `background-image: url(${videoContent});` : ""
        } ${!isMute ? "border: 3px solid #2688EB;" : ""} ${
    fullscreen ? "max-height: 100%" : ""
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

export const VideosList = ({ resize }) => {
  const screenWidth = window.screen.width;
  console.log(screenWidth)
  let size = 25;

  const { round, ceil, sqrt } = Math;
  let gridCols = round(sqrt(list.length)) < 5 ? round(sqrt(list.length)) : 5;
  let gridRows = ceil(sqrt(list.length)) < 5 ? ceil(sqrt(list.length)) : 5;

  if (screenWidth <= 1250) {
    gridCols = gridCols >= 4 ? 4 : gridCols;
    // gridRows = gridRows >= 3 ? 3 : gridRows
    size = 20
  }
  if (screenWidth <= 1000) {
    gridCols = gridCols >= 3 ? 3 : gridCols
    // gridRows = 6
    size = 18
  }
  if (screenWidth <= 750) {
    gridCols = gridCols >= 2 ? 2 : gridCols;
    size = 12
  }

  console.log(gridCols, gridRows, size)

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
  let divConainer = document.createElement("div");

  swiper.style.height = "100%";

  divConainer.appendChild(swiper);

  // wrapper.style.paddingRight = "0rem"

  wrapper.innerHTML = `
        ${pages
          .map(
            (page) =>
              `<ul class="videos_list swiper-slide" style="grid-template-rows: repeat(${gridRows}, minmax(0, 1fr)); grid-template-columns: repeat(${gridCols}, minmax(0, 1fr));">
      ${page
        .map((item) =>
          VideoItem({
            video: item,
            fullscreen: list.length === 1 ? true : false,
          })
        )
        .join("")}
      </ul>`
          )
          .join("")}
        ))}
  `;

  videosSection.innerHTML = divConainer.innerHTML;

  new Swiper(".swiper-container", {
    // Optional parameters
    direction: "horizontal",
    loop: false,

    // Navigation arrows
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
  });
};

export const list = [
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
