import { InfoSection } from "./components/InfoSection.js";
import { VideosList } from "./components/VideosList.js";
import { Chat } from "./components/Chat.js";
import { Participants } from "./components/Participants.js";
import { ShareScreen } from "./components/ShareScreen.js";
import { Whiteboard } from "./components/Whiteboard.js";
import { LeftStream } from "./components/LeftStream.js";

const moreButton = document.querySelector("#more_button");
const videosSection = document.querySelector("#videos_section");
const securityButton = document.querySelector("#security_button");

const displayContent = () => {
  InfoSection();
  VideosList({ resize: false });
  Whiteboard();
  LeftStream();
};

function resizeContent() {
  console.log("resise main")
  InfoSection();
  if (document.querySelector("#videos_section")) {
    VideosList({ resize: true });
    console.log("resizes")
  }

  if (document.querySelector(".share_screen")) {
    ShareScreen({ resize: true, stateStr: null });
  }
};

document.addEventListener("DOMContentLoaded", displayContent());

window.onresize = resizeContent;

let moreListIsOpen = false;
let securityListIsOpen = false;

securityButton.addEventListener("click", (e) => {
  e.stopPropagation();
  if (securityListIsOpen) {
    securityButton.removeChild(securityButton.lastChild);
    securityListIsOpen = false;

    securityButton.firstElementChild.style.backgroundColor = null;
    securityButton.querySelector("p").style.color = null;
  } else {
    const securityListNode = `<div class="security_list">
      <div>
        <p>About Meeting</p>
        <ul
          class="security_sublist"
          style="border-bottom: 1px solid #F4F4F4; padding-bottom: 1.5rem;"
        >
          <li>
            <img src="./icons/correct.svg" width="10" height="10" alt="" />
            <p>Lock Meeting</p>
          </li>
          <li>
            <img src="./icons/correct.svg" width="10" height="10" alt="" />
            <p>Enable Waiting Room</p>
          </li>
          <li>
            <img src="./icons/correct.svg" width="10" height="10" alt="" />
            <p>Hide Profile Pictures</p>
          </li>
        </ul>
      </div>
      <div>
        <p>Allow participants to:</p>
        <ul class="security_sublist">
          <li>
            <img src="./icons/correct.svg" width="10" height="10" alt="" />
            <p>Share Screen</p>
          </li>
          <li>
            <img src="./icons/correct.svg" width="10" height="10" alt="" />
            <p>Chat</p>
          </li>
          <li>
            <img src="./icons/correct.svg" width="10" height="10" alt="" />
            <p>Rename</p>
          </li>
          <li>
            <img src="./icons/correct.svg" width="10" height="10" alt="" />
            <p>Start Video</p>
          </li>
          <li>
            <img src="./icons/correct.svg" width="10" height="10" alt="" />
            <p>Start Whiteboards</p>
          </li>
        </ul>
      </div>
    </div>`;

    securityButton.insertAdjacentHTML("beforeend", securityListNode);
    securityListIsOpen = true;

    securityButton.firstElementChild.style.backgroundColor = "#2688EB";
    securityButton.querySelector("p").style.color = "#2688EB";
  }
});

moreButton.addEventListener("click", (e) => {
  e.stopPropagation();

  if (moreListIsOpen) {
    moreButton.removeChild(document.querySelector(".more_list"));
    moreListIsOpen = false;

    moreButton.firstElementChild.style.backgroundColor = null;
    moreButton.querySelector("p").style.color = null;
  } else {
    const moreListNode = `<div class="more_list">
    <p>Meeting</p>

    <ul class="more_sublist">
      <li class="more_sublist_item">
        <img src="./icons/windows-full.svg" width="15" height="15" alt="" />
        <p>Speaker</p>
      </li>
      <li class="more_sublist_item">
        <img src="./icons/gallary.svg" width="15" height="15" alt="" />
        <p>Gallery</p>
      </li>
      <li class="more_sublist_item">
        <img src="./icons/immersive.svg" width="15" height="15" alt="" />
        <p>Immersive</p>
      </li>
      <li class="more_sublist_item" id="about_meeting_button">
        <img src="./icons/about.svg" width="15" height="15" alt="" />
        <p>About Meeting</p>
      </li>
    </ul>
  </div>`;
    moreButton.insertAdjacentHTML("beforeend", moreListNode);
    moreListIsOpen = true;
    clickMoreList();
    clickAboutMeeting();

    moreButton.firstElementChild.style.backgroundColor = "#2688EB";
    moreButton.querySelector("p").style.color = "#2688EB";
  }
});

function clickMoreList() {
  document.querySelector(".more_list").addEventListener("click", (e) => {
    e.stopPropagation();
  });
}

function clickAboutMeeting() {
  document
    .querySelector("#about_meeting_button")
    .addEventListener("click", (e) => {
      videosSection.innerHTML = `<div class="meeting_info">
      <p>Name Meeting</p>

      <ul class="meeting_info_list">
        <li>
          <p>Meeting ID</p>
          <p>852 852 8520</p>
        </li>
        <li>
          <p>Host</p>
          <p>Host Name</p>
        </li>
        <li>
          <p>Passcode</p>
          <p>kjuw654</p>
        </li>
        <li class="invitation_link">
          <p>Invitation link</p>
          <div>
            <a>https://kasik.mena.com/d/56449646546</a>
            <img
              src="./icons/copy.svg"
              width="15"
              height="15"
              style="cursor: pointer"
              alt=""
            />
          </div>
        </li>
        <li>
          <p>Participant</p>
          <p>987546</p>
        </li>
        <li>
          <p>Encryption</p>
          <p>Enabled</p>
        </li>
      </ul>
    </div>`;

    moreButton.removeChild(document.querySelector(".more_list"));
    moreListIsOpen = false;
  
    moreButton.firstElementChild.style.backgroundColor = null;
    moreButton.querySelector("p").style.color = null;
    });

}

// function clickMoreList() {
//   document.querySelector(".more_list").addEventListener("click", (e) => {
//     e.stopPropagation()
//   })
// }

// if (moreListIsOpen) {
//   console.log("is open")
//   const aboutMeetingButton = document.querySelector("#about_meeting_button")
//   aboutMeetingButton.addEventListener("click", (e) => {
//     // e.stopPropagation()
//     console.log("clicked " + e);
//     videosSection.innerHTML = `<div class="meeting_info">
//       <p>Name Meeting</p>

//       <ul class="meeting_info_list">
//         <li>
//           <p>Meeting ID</p>
//           <p>852 852 8520</p>
//         </li>
//         <li>
//           <p>Host</p>
//           <p>Host Name</p>
//         </li>
//         <li>
//           <p>Passcode</p>
//           <p>kjuw654</p>
//         </li>
//         <li class="invitation_link">
//           <p>Invitation link</p>
//           <div>
//             <a>https://kasik.mena.com/d/56449646546</a>
//             <img
//               src="./icons/copy.svg"
//               width="15"
//               height="15"
//               style="cursor: pointer"
//               alt=""
//             />
//           </div>
//         </li>
//         <li>
//           <p>Participant</p>
//           <p>987546</p>
//         </li>
//         <li>
//           <p>Encryption</p>
//           <p>Enabled</p>
//         </li>
//       </ul>
//     </div>`;
//   })
// } else {
//   console.log("non open")
// }
