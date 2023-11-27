const videosSection = document.querySelector("#videos_section");
const chatButton = document.querySelector("#chat_button");
let cancelChatButton = null

chatButton.addEventListener("click", () => {
  if (document.querySelector(".chat")) return;

  Chat();
  cancelChatButton = document.querySelector("#cancel_chat")
  closeChat(cancelChatButton);
});

function closeChat(element) {
  element.addEventListener("click", () => {
    videosSection.removeChild(document.querySelector(".chat"));
    chatButton.firstElementChild.style.backgroundColor = null
    chatButton.querySelector("p").style.color = null
  });
}

export const Chat = () => {
  chatButton.firstElementChild.style.backgroundColor = "#2688EB"
  chatButton.querySelector("p").style.color = "#2688EB"

  videosSection.insertAdjacentHTML(
    "beforeend",
    `<div class="chat">
    <div class="chat_header">
      <p>Chat</p>
      <img src="./icons/cancel.svg" width="10" height="10" alt="" id="cancel_chat" style="cursor: pointer;" />
    </div>

    <span></span>

    <ul class="messages_list">
      ${messages
        .map(
          (ms) =>
            `<li>
        <img
          src=${ms.image}
          width="30"
          height="30"
          alt=""
        />
        <div>
          <p>${ms.name}</p>
          <p style="max-width: 100%;">${ms.message}</p>
        </div>
      </li>`
        )
        .join("")}
    </ul>

    <div class="write_message">
      <div>
        <img src="./icons/chat-face.svg" width="25" height="25" alt="" />
      </div>
      <input type="text" placeholder="Type message" />
      <div>
        <img src="./icons/send.svg" width="25" height="25" alt="" />
      </div>
    </div>
  </div>`
  );
};

const messages = [
  {
    image: "./images/profile-picture.png",
    name: "Amine",
    message: "nsienfgvpisnfd jbnsadfnbafafdbm",
  },
  {
    image: "./images/profile-picture.png",
    name: "Amine",
    message:
      "nsienfgvpisnfdjbnsadfn  bafafdbmnsienfgv pisnf djbnsadfnbaf afdbmn sienfgvpisnfdjbnsadf nbafafdbmnsienfgvpisn fdjbnsadfnba fafdbmn sienfg vpisnfdjbnsadf nbafafdb  mnsienfgvpi snfdjbnsad fnbafafdbmn sienfgvpisnfdjb nsadf nbafaf d bm nsie nfgvp isnfd jbn sadf nbafa fdbm",
  },
  {
    image: "./images/profile-picture.png",
    name: "Amine",
    message: "nsienfgvpisnfdjbnsadfnbafafdbm",
  },
  {
    image: "./images/profile-picture.png",
    name: "Amine",
    message:
      "nsienfgvp isnfdjbn sadfnbafafdbmnsie nfgvpisnf  djbnsa  dfnb afafdbm nsienfgvpis nfdjbn sadfn bafafdbmns ienf gvpis nfdjbn sadfnb afafd bmnsien fgvpi snfdj bnsa dfnbaf afdbm nsien fgvp isnfd jbn sadfn bafafd bmnsi enfgvpis nfdj bnsa dfnb afafdbmn sienf gvpisn fdjbn sadfnb afafdb mn sienf gvpisn fdjbn sadfnbaf afdbm",
  },
  {
    image: "./images/profile-picture.png",
    name: "Amine",
    message: "nsienfgvpisnfdjbnsadfnbafafdbm",
  },
  {
    image: "./images/profile-picture.png",
    name: "Amine",
    message: "nsienfgvpisnfdjbnsadfnbafafdbm",
  },
  {
    image: "./images/profile-picture.png",
    name: "Amine",
    message: "nsienfgvpisnfdjbnsadfnbafafdbm",
  },
  {
    image: "./images/profile-picture.png",
    name: "Amine",
    message: "nsienfgvpisnfdjbnsadfnbafafdbm",
  },
  {
    image: "./images/profile-picture.png",
    name: "Amine",
    message: "nsienfgvpisnfdjbnsadfnbafafdbm",
  },
  {
    image: "./images/profile-picture.png",
    name: "Amine",
    message: "nsienfgvpisnfdjbnsadfnbafafdbm",
  },
  {
    image: "./images/profile-picture.png",
    name: "Amine",
    message: "nsienfgvpisnfdjbnsadfnbafafdbm",
  },
  {
    image: "./images/profile-picture.png",
    name: "Amine",
    message: "nsienfgvpisnfdjbnsadfnbafafdbm",
  },
  {
    image: "./images/profile-picture.png",
    name: "Amine",
    message: "nsienfgvpisnfdjbnsadfnbafafdbm",
  },
  {
    image: "./images/profile-picture.png",
    name: "Amine",
    message: "nsienfgvpisnfdjbnsadfnbafafdbm",
  },
  {
    image: "./images/profile-picture.png",
    name: "Amine",
    message: "nsienfgvpisnfdjbnsadfnbafafdbm",
  },
  {
    image: "./images/profile-picture.png",
    name: "Amine",
    message: "nsienfgvpisnfdjbnsadfnbafafdbm",
  },
  {
    image: "./images/profile-picture.png",
    name: "Amine",
    message: "nsienfgvpisnfdjbnsadfnbafafdbm",
  },
  {
    image: "./images/profile-picture.png",
    name: "Amine",
    message: "nsienfgvpisnfdjbnsadfnbafafdbm",
  },
  {
    image: "./images/profile-picture.png",
    name: "Amine",
    message: "nsienfgvpisnfdjbnsadfnbafafdbm",
  },
  {
    image: "./images/profile-picture.png",
    name: "Amine",
    message: "nsienfgvpisnfdjbnsadfnbafafdbm",
  },
];
