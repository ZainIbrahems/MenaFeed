const videosSection = document.querySelector("#videos_section");
const participantsButton = document.querySelector("#participants_button");

participantsButton.addEventListener("click", () => {
  if (document.querySelector(".participants")) return;

  Participants();
  clickParticipantOptions(
    document.querySelectorAll(".participant_options_button")
  );
  clickParticipant(document.querySelectorAll(".participant_item"));
  closeParticipants(document.querySelector("#cancel_participants_list"));
});

function clickParticipant(elements) {
  for (let i = 0; i <= elements.length; i++) {
    if (elements[i]) {
      elements[i].addEventListener("click", () => {
        console.log(i);
        elements[i].removeChild(elements[i].lastChild);
      });
    }
  }
}

function clickParticipantOptions(elements) {
  for (let i = 0; i <= elements.length; i++) {
    if (elements[i]) {
      elements[i].addEventListener("click", () => {
        document.querySelectorAll(".participant_item")[i].insertAdjacentHTML(
          "beforeend",
          `
                        <div class="participant_options_list">
                        <div>
                          <img src="./icons/mic-muted-black.svg" alt="mic" />
                          <p>Mute</p>
                        </div>
                        <div>
                          <img src="./icons/exit-black.svg" alt="exit" />
                          <p>Dismiss</p>
                        </div>
                        <div>
                          <img src="./icons/question-mark.svg" alt="?" />
                          <p>Block</p>
                        </div>
                      </div>
                    </div>`
        );
      });
    }
  }
}

function closeParticipants(element) {
  element.addEventListener("click", () => {
    videosSection.removeChild(document.querySelector(".participants"));
    participantsButton.firstElementChild.style.backgroundColor = null
    participantsButton.querySelectorAll(":last-child").forEach(i => i.style.color = null)
  });
}

const ParticipantItem = ({ name, image, id }) => {
  return `<li class="participant_item">
    <img
      src=${image}
      width="30"
      height="30"
      alt=""
    />
    <p>${name}</p>
    <div class="participants_options">
      <img src="./icons/mic-blue.svg" width="12" height="12" alt="" />
      <img src="./icons/video-blue.svg" width="12" height="12" alt="" />
      <img
        src="./icons/options-blue.svg"
        width="12"
        height="12"
        alt=""
        class="participant_options_button"
      />
    </div>
  </li>`;
};

export const Participants = () => {
  participantsButton.firstElementChild.style.backgroundColor = "#2688EB";
  participantsButton.querySelectorAll(":last-child").forEach(i => i.style.color = "#2688EB")

  videosSection.insertAdjacentHTML(
    "beforeend",
    `<div class="participants">
    <div class="participants_header">
      <p>Participants</p>
      <img
        src="./icons/cancel.svg"
        width="10"
        height="10"
        alt=""
        id="cancel_participants_list"
        style="cursor: pointer;"
      />
    </div>

    <span></span>

    <ul class="participants_list">
      ${participantsList
        .map((par) =>
          ParticipantItem({ id: par.id, image: par.image, name: par.name })
        )
        .join("")}
    </ul>

    <div class="participants_actions">
      <div>
        <span>+</span>
        <p>Add Participants</p>
      </div>
      <div>
        <img src="./icons/clip.svg" width="10" height="10" alt="" />
        <p>Copy Invite Link</p>
      </div>
    </div>
  </div>`
  );
};

const participantsList = [
  {
    id: "1",
    name: "me",
    image: "./images/profile-picture.png",
  },
  {
    id: "2",
    name: "ahmed",
    image: "./images/profile-picture2.png",
  },
  {
    id: "3",
    name: "ahmed",
    image: "./images/profile-picture2.png",
  },
  {
    id: "4",
    name: "ahmed",
    image: "./images/profile-picture2.png",
  },
  {
    id: "5",
    name: "ahmed",
    image: "./images/profile-picture2.png",
  },
  {
    id: "6",
    name: "ahmed",
    image: "./images/profile-picture2.png",
  },
  {
    id: "7",
    name: "ahmed",
    image: "./images/profile-picture2.png",
  },
  {
    id: "8",
    name: "ahmed",
    image: "./images/profile-picture2.png",
  },
  {
    id: "9",
    name: "ahmed",
    image: "./images/profile-picture2.png",
  },
  {
    id: "10",
    name: "ahmed",
    image: "./images/profile-picture2.png",
  },
  {
    id: "11",
    name: "ahmed",
    image: "./images/profile-picture2.png",
  },
  {
    id: "12",
    name: "ahmed",
    image: "./images/profile-picture2.png",
  },
  {
    id: "13",
    name: "ahmed",
    image: "./images/profile-picture2.png",
  },
  {
    id: "14",
    name: "ahmed",
    image: "./images/profile-picture2.png",
  },
  {
    id: "15",
    name: "ahmed",
    image: "./images/profile-picture2.png",
  },
  {
    id: "16",
    name: "ahmed",
    image: "./images/profile-picture2.png",
  },
  {
    id: "17",
    name: "ahmed",
    image: "./images/profile-picture2.png",
  },
  {
    id: "18",
    name: "ahmed",
    image: "./images/profile-picture2.png",
  },
  {
    id: "19",
    name: "ahmed",
    image: "./images/profile-picture2.png",
  },
];
