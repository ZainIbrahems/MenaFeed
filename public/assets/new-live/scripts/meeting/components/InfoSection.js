const infoSection = document.querySelector("#info_section");


export function InfoSection() {
  const screenWidth = window.screen.width;
  if (screenWidth >= 480) {
    infoSection.innerHTML = `<div style="display: flex; justify-content: flex-end; padding: 0.3rem 1rem;">
            <img
            src="./icons/windows.svg"
            width="25px"
            height="25px"
            class="windows_icon"
            alt=""
          />
          </div>`;
  } else {
    infoSection.innerHTML = `
          <div class="info_list">
            <div class="info_list_main">
              <div style="background-color: #e64646" id="leave_studio_button">
                <img src="./icons/exit.svg" alt="exit" />
                <p>Leave</p>
              </div>
    
              <div
                class="add_participant"
                style="
          height: fit-content;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 8px;
            gap: 0.5rem;
            border-radius: 100px;
            background-color: #2688eb;
          "
              >
                <img
                  src="./icons/participants.svg"
                  width="20px"
                  height="20px"
                  style="align-self: flex-start;"
                  alt=""
                />
                <p style="color: #2688eb">500</p>
              </div>
            </div>
            <img
              src="./icons/windows.svg"
              width="35px"
              height="35px"
              style="rotate: 180deg; cursor: pointer;"
              alt=""
            />
          </div>
        `;
  }
}
