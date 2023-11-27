
export const LeftStream = () => {
    document.querySelector("#leave_stream").addEventListener("click", () => {
      console.log("clicked")
    let divContainer = document.createElement("div")
    divContainer.innerHTML = `
    <div class="left-stream-alert" style="display: flex;">
      <div style="display: none;background-color: #2688eb">
        <div>
          <img src="./icons/participants.svg" alt="participants" />
          <p>217K</p>
        </div>
        <p>00:24:03</p>
      </div>
      <div>
        <img src="./icons/hand.svg" alt="wave" />
        <div class="left-stream-alert-header">
          <h2>You left the stream</h2>
          <p>Have a nice day!</p>
        </div>
        <div class="left-stream-alert-list">
          <p>Left by mistake?</p>
          <div style="background-color: #2688eb" id="rejoin-button">
            <img src="./icons/exit.svg" alt="exit" />
            <p>Rejoin</p>
          </div>
        </div>
      </div>
    </div>`

    document.body.append(divContainer.firstElementChild)
    rejoin()
    })

    function rejoin() {
    document.querySelector("#rejoin-button").addEventListener("click", () => {
      document.body.removeChild(document.querySelector(".left-stream-alert")) 
    })
    }
}
