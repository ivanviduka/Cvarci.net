let cartItems = [];
let addToCartButtons;

window.onload = (event) => {
    addToCartButtons = document.querySelectorAll(".shopping-items ul li form .btn-primary")
    addToCartButtons.forEach(button => {
        button.addEventListener('click', addToCart);
    })

    if(document.querySelector(".shopping-cart-dropdown ul").getElementsByTagName("li").length == 0){
        document.getElementById("buy-from-mini-cart").setAttribute("disabled", "true");
    }
    
};

function addToCart(event) {

    event.preventDefault();
    event.target.setAttribute("disabled", "true");
    document.getElementById("buy-from-mini-cart").removeAttribute("disabled");

    let selectedProduct = event.target.parentNode.parentNode;

    let selectedProductID = selectedProduct.id;
    let selectedProductPicture = selectedProduct.querySelector('.product-picture');
    let selectedProductName = selectedProduct.querySelector('.heading3');
    let selectedProductPrice = selectedProduct.querySelector('.product-price');
    let selectedProductQuantity = selectedProduct.querySelector('.product-quantity');

    let newItem = {
        id: selectedProductID,
        name: selectedProductName.innerHTML,
        img_min: selectedProductPicture.firstElementChild.srcset,
        img: selectedProductPicture.lastElementChild.src,
        price: parseInt(selectedProductPrice.firstElementChild.innerHTML),
        quantity: parseInt(selectedProductQuantity.firstElementChild.firstElementChild.value)
    }
    cartItems.push(newItem);

    

    let list = document.querySelector(".shopping-cart-dropdown ul");
    let size = list.getElementsByTagName("li").length;
    let li = document.createElement("li");
    li.innerHTML =
        `<input type='hidden' name="productArray[${size}][id]" value="${newItem.id}"/>
         <input type='hidden' name="productArray[${size}][name]" value="${newItem.name}"/>
         <input type='hidden' name="productArray[${size}][imgMinURL]" value="${newItem.img_min}"/>
         <input type='hidden' name="productArray[${size}][imgURL]" value="${newItem.img}"/>
         <input type='hidden' name="productArray[${size}][price]" value="${newItem.price}"/>
         <input type='hidden' name="productArray[${size}][quantity]" value="${newItem.quantity}"/>
        <p class="cart-item-title">
            ${newItem.name}
        </p>
        
        <picture>
            <source media="(max-width: 966px)" srcset="${newItem.img_min}">
            <source media="(min-width: 967px)" srcset="${newItem.img}">
            <img src="${newItem.img}" alt="${newItem.name}" width="95" height="95" loading="lazy">
        </picture>
     
        <a href="#" aria-label="Remove item from shopping cart">
            <span class="material-icons-outlined" onclick="removeFromCart(event)">
            highlight_off
            </span>
        </a>
        
        <div class="cart-item-info-text">
            <p>
                Cijena: <span class="cart-item-price">${newItem.price * newItem.quantity} kn</span>
            </p>
        
            <p>
                Količina: <span class="cart-item-quantity">${newItem.quantity}</span>
            </p>
        </div>
        </li>`

    list.appendChild(li);

    let shoppingCartCount = document.querySelector('#lblCartCount');
    shoppingCartCount.innerHTML = cartItems.length;
}

function removeFromCart(event) {
    event.preventDefault();
    let node = event.target.parentNode.parentNode
    let parentNode = node.parentNode
    let index = Array.from(parentNode.children).indexOf(node)
    let listItemID = cartItems[index].id
    cartItems.splice(index, 1)
    parentNode.removeChild(node)
    let button = document.querySelector(`#${listItemID} form .btn-primary`)
    button.disabled = false

    let shoppingCartCount = document.querySelector('#lblCartCount');
    shoppingCartCount.innerHTML = cartItems.length;

    if(document.querySelector(".shopping-cart-dropdown ul").getElementsByTagName("li").length == 0){
        document.getElementById("buy-from-mini-cart").setAttribute("disabled", "true");
    }
}