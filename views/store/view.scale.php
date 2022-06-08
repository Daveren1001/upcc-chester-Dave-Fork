<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once "views/shared/headers.php"; ?>
    <style>
        .products-section {
            padding: 0 15px;
        }

        .increment-controls {
            border: none;
            width: 40px;
            height: 40px;
            background-color: #555;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
        }

        .increment-controls:hover {
            cursor: pointer;
            background-color: #333;
        }

        #minus-increment {
            border-radius: 5px 0 0 5px;
        }

        #plus-increment {
            border-radius: 0 5px 5px 0;
        }

        #item_count::-webkit-outer-spin-button,
        #item_count::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        #item_count[type=number] {
            -moz-appearance: textfield;
        }

        #email-popup-container {
            height: 100vh;
            width: 100vw;
            backdrop-filter: blur(3px);
            position: absolute;
            top: 0;
            left: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            display: none;
            opacity: 0;
            transition: opacity .15s ease-in-out;
            background-color: rgba(0, 0, 0, .1);
        }

        #email-popup {
            display: block;
            margin: 0;
            height: auto;
            width: 700px;
            background-color: white;
            box-shadow: 6px 6px 6px -6px rgba(0, 0, 0, .2);
        }
    </style>
    <title>Product <?php echo addslashes($_GET["id"]); ?> | UPCC</title>
</head>

<body>
    <?php include_once("views/shared/nav.php"); ?>
    <input type="hidden" id="product_id" style="display: hidden;" value="<?php echo $_GET['product_id']; ?>">
    <div flex="v" main>
        <div flex="h">
            <button button contain="dark" small flex="h" v-center nogap onclick="history.back()"><img src="../api/assets/img?name=arrow-right.webp&type=webp" alt="back" style="transform: rotate(180deg);">Back</button>
        </div>
        <div flex>
            <div style="height: 300px; width: 300px; box-shadow: 6px 6px 6px -6px rgba(0, 0, 0, .2); flex-shrink: 0;">
                <img src="" alt="placeholder">
            </div>
            <div flex="v" style="gap: 15px; padding: 15px 0;">
                <div class="products-section">
                    <h2 id="product-name" style="margin: .3em 0;">Product Name</h2>
                    <span id="product-id">#000-00000</span>
                    <p id="product-description" style="color: #999;">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Repudiandae, dolores soluta? Iure atque
                        amet quam modi incidunt commodi deleniti, distinctio mollitia! Aut sequi eum repellat animi soluta est autem ipsa!
                    </p>
                </div>
                <div class="products-section">
                    <div flex v-center nogap>
                        <button class="increment-controls" id="minus-increment" onclick="decrementItemCount()">
                            -
                        </button>
                        <input type="number" id="item_count" form-input sharp-edges style="background-color: #f5f5f5; width: 5em; height: 40px; font-size: 1em;
                            text-align: center;" value="1" placeholder="1">
                        <button class="increment-controls" id="plus-increment" onclick="incrementItemCount()">
                            +
                        </button>
                    </div>
                </div>
                <div class="products-section" flex>
                    <button button="secondary" style="gap: 5px;" flex v-center onclick="showEmailPopup()">
                        <img src="../api/assets/img?name=email.webp&type=webp" alt="email">
                        Email Now
                    </button>
                    <button button="good" style="gap: 5px;" flex v-center onclick="checkAuth()">
                        <img src="../api/assets/img?name=add-to-cart.webp&type=webp" alt="add to cart">
                        Add to Cart
                    </button>
                </div>
                <div id="popup-message" style="opacity: 0; display: none; padding: 15px 20px; transition: opacity .3s ease-in-out;" flex></div>
                <div class="products-section" flex="v" style="gap: 0; padding: 15px 20px; background-color: #f5f5f5; border-radius: 5px;">
                    <div style="width: 100%;">
                        <h3 style="margin: .3em 0;">More Details</h3>
                        <p style="color: #999;">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Expedita recusandae dicta praesentium itaque
                            quibusdam adipisci ratione excepturi velit nulla, assumenda officia, aspernatur quos atque eveniet repellendus
                            laboriosam. Ut, totam assumenda. Lorem ipsum dolor, sit amet consectetur adipisicing elit. Doloremque
                            fugiat nam repellendus id delectus quia quod voluptas voluptate culpa aliquid consequatur labore odit
                            tempore voluptatum sed, non quo porro. Nobis.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div id="email-popup-container" style="flex-shrink: 0;">
            <div id="email-popup" flex="v" style="flex-shrink: 0;">
                <div flex="h" h-end>
                    <div style="height: 50px; width: 50px; background-color: #333; cursor: pointer;" flex="h" h-center v-center onclick="hideEmailPopup()">
                        <img src="../api/assets/img?name=close.webp&type=webp" alt="close">
                    </div>
                </div>
                <div flex="v" style="padding: 25px 35px;">
                    <div>
                        <h2 id="product_name">Product Name</h2>
                    </div>
                    <div>
                        <form onsubmit="return false" method="POST" id="email_form">
                            <div flex="v">
                                <input type="email" form-input id="email" placeholder="Email address" style="border-bottom: 1px solid #aaa; border-radius: 0;">
                                <input type="text" form-input id="phone_number" placeholder="Phone number" style="border-bottom: 1px solid #aaa; border-radius: 0;">
                                <textarea form-input id="message" placeholder="Type your message here" rows="3" style="border-bottom: 1px solid #aaa; border-radius: 0;"></textarea>
                                <div fullwidth flex="h" h-end>
                                    <button button="secondary" onclick="sendMail()">Send</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include_once "views/shared/footers.php"; ?>
    <script>
        var container_display = false;
        fetch("getProductFromDb.php")
            .then(response => response.json)
            .then(json => displayDataToDom(json));

        function displayDataToDom(json) {
            // code here
        }

        function decrementItemCount() {
            const item_count = document.querySelector("#item_count");
            if (item_count.value - 1 < 1) return;
            --item_count.value;
        }

        function incrementItemCount() {
            const item_count = document.querySelector("#item_count");
            ++item_count.value;
        }

        function showEmailPopup() {
            const email_popup_container = document.querySelector("#email-popup-container");
            fadeInFlex(email_popup_container);
            container_display = true;
        }

        function hideEmailPopup() {
            const email_popup_container = document.querySelector("#email-popup-container");
            email_popup_container.style.display = "flex";
            fadeOut(email_popup_container);
            container_display = false;
        }

        document.addEventListener("click", (event) => {
            if (!container_display) return;
            const email_popup_container = document.querySelector("#email-popup-container");
            let targetElement = event.target;
            if (targetElement == email_popup_container) hideEmailPopup();
        });

        function checkAuth() {
            const popup_message = document.querySelector("#popup-message");
            fetch("back/isAuth.php")
                .then(response => response.json())
                .then(json => {
                    if (json["auth"]) return addToCart(product_id);
                    popup_message.style.backgroundColor = "#ffbabb";
                    popup_message.style.border = "2px solid #cc6264";
                    popup_message.innerHTML = "<div>You are currently not signed in! Click <a href='signup.php'>here</a> to sign up for an account.</div>";
                    fadeInFlex(popup_message);
                });
        }

        function addToCart(product_id) {
            fetch(`addToCart.php?product_id=${product_id}`)
                .then(response => response.json)
                .then(json => {
                    // code here
                });
        }

        function sendMail() {
            const email_inputs = document.querySelectorAll("#email_form input");
            const email_textareas = document.querySelectorAll("#email_form textarea");
            let inputs = {};
            email_inputs.forEach((input) => {
                inputs[input.id] = input.value;
            });
            email_textareas.forEach((input) => {
                inputs[input.id] = input.value;
            });
            fetch("back/sendMail.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({
                        "details": inputs,
                    }),
                })
                .then(response => response.json())
                .then(json => {
                    if (json["response_code"] !== 200) return;
                    const popup_message = document.querySelector("#popup-message");
                    popup_message.style.backgroundColor = "#a5bff2";
                    popup_message.style.border = "2px solid #0f2755";
                    popup_message.innerHTML = "<div>Email sent successfully!</div>";

                    const email_popup_container = document.querySelector("#email-popup-container");
                    fadeOut(email_popup_container);
                    setTimeout(() => {
                        fadeIn(popup_message);
                    }, 150);
                });
        }
    </script>
</body>

</html>