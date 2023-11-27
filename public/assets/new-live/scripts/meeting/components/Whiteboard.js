import { ShareScreen } from "./ShareScreen.js";

const whiteboardButton = document.querySelector("#whiteboard_button");

whiteboardButton.addEventListener("click", () => {
    ShareScreen({resize: false, stateStr: "whiteboard"})
})

export const Whiteboard = () => {
    let whiteboardStr = `
            <div class="whiteboard">
                <div>

                </div>

                <ul>
                    <li>
                        <img src="./images/user-image.png" width="10" height="10" style="width: 90%; height: 90%" alt="">
                    </li>
                    <li>
                        <img src="./images/user-image.png" width="10" height="10" style="width: 90%; height: 90%" alt="">
                    </li>
                    <li>
                        <img src="./images/user-image.png" width="10" height="10" style="width: 90%; height: 90%" alt="">
                    </li>
                    <li>
                        <img src="./images/user-image.png" width="10" height="10" style="width: 90%; height: 90%" alt="">
                    </li>
                    <li>
                        <img src="./images/user-image.png" width="10" height="10" style="width: 90%; height: 90%" alt="">
                    </li>
                    <li>
                        <img src="./images/user-image.png" width="10" height="10" style="width: 90%; height: 90%" alt="">
                    </li>
                    <li>
                        <img src="./images/user-image.png" width="10" height="10" style="width: 90%; height: 90%" alt="">
                    </li>
                    <li>
                        <img src="./images/user-image.png" width="10" height="10" style="width: 90%; height: 90%" alt="">
                    </li>
                    <li>
                        <img src="./images/user-image.png" width="10" height="10" style="width: 90%; height: 90%" alt="">
                    </li>
                    <li>
                        <img src="./images/user-image.png" width="10" height="10" style="width: 90%; height: 90%" alt="">
                    </li>
                    <li>
                        <img src="./images/user-image.png" width="10" height="10" style="width: 90%; height: 90%" alt="">
                    </li>
                    <li>
                        <img src="./images/user-image.png" width="10" height="10" style="width: 90%; height: 90%" alt="">
                    </li>
                    <li>
                        <img src="./images/user-image.png" width="10" height="10" style="width: 90%; height: 90%" alt="">
                    </li>
                </ul>
            </div>
        `;

    return whiteboardStr;
};
