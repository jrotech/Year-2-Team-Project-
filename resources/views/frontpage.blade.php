<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<style>
    *{
        border: 0;
        padding: 0;
        margin: 0;
    }
.NavBar{
    padding: 0;
    margin: 0;
    background-color: #010035;
    overflow: hidden;
    height: 50px;
}
.NavBar li{
display: inline;
float: right;
margin-right: 20px;
}
.NavBar a{
    color: white;
    display: block;
    padding: 8px;
    padding: 4px;
    text-decoration: none;
}
    .techForgeImage img{
         position: absolute;
       top: 0%;
       left: 0%;
       height: 50px;
    }
    .searchBar{
        display: flex;
        justify-content: center;
        align-items: center;
        flex-grow: 1;
    }
    .searchBar input[type=text]{
       width: 100%;
       padding: 5px;
       border: none;
       border-radius: 5px;
    }
    .GreyNavbar{
        background-color: #263238;
        overflow: hidden;
        height: 50px;
        display: flex;
        justify-content: center;
        align-items: center;
    }
.SecondBar li{
    display: inline;
    float: center;
    margin-right: 20px;
}
.SecondBar a{
    color: white;
    text-decoration: none;
}
.pcSetup img{
    width: 100%;
    height: 400px;
    max-height: 100%;
}
.signupForm {
    position: absolute;
    right: 0;
    width: 300px; /* Adjust width as needed */
    padding: 20px;
    margin: 20px;
    display: flex;
    flex-direction: column;
    gap: 10px; /* Adds space between inputs */
}
.signupForm input[type=text] {
    width: 100%;
    padding: 10px;
    margin: 5px 0;
    border-radius: 5px;
    border: none;
    background-color: #A9A9A9;
    color: black;
}
.signupForm button{
    width: 100%;
    padding: 10px;
    margin: 5px 0;
    border-radius: 5px;
    border: none;
    background-color: #010035;
    color: white;
}
.whiteTechForgeImg img{
    width: 300px;
}
.NicePcImg img{
    width: 300px;
    background-color: grey;
}
.NicePcImg{
    background-color: #F5F5F5;
    padding: 20px;
    margin: 20px 0;
    border-radius: 5px;
    width: 100%;
    display: flex;
    justify-content: space-around;
    align-items: center;
    gap: 20px;
}
.NicePcImg img {
    width: 300px;
    height: auto;
    display: block;
    object-fit: cover;
}
.NicePcImg figure {
    text-align: center;
    margin: 0;
}
.NicePcImg figcaption {
    margin-top: 10px;
    font-size: 14px;
    color: #010035;
}
.NicePcrating {
    color: #FFD700; 
    margin-top: 5px;
    font-size: 16px;
}
.NicePcrating i {
    margin: 0 2px;
}
.ExtremePcrating {
    color: #FFD700; 
    margin-top: 5px;
    font-size: 16px;
}
.ExtremePcrating i {
    margin: 0 2px;
}
.far.fa-star {
    color: #ccc; 
}
.NicerPCrating {
    color: #FFD700; 
    margin-top: 5px;
    font-size: 16px;
}
.NicerPCrating i {
    margin: 0 2px;
}
.SeeMore{
    background-color: #010035;
    color: white;
    padding: 10px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.Categories{
    background-color: #035a82;
    color: white;
    width: 98%;
    height: 100%;
    border-radius: 5px;
    padding: 10px;
    
}


.Categories img{
    width: 180px;
    height: 200px;
    margin: 10px;
    border-radius: 5px;
    filter:brightness(50%);
}

.CategoryImages{
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 10px;
}

.CaseText{
    position: absolute;
    top: 1500px;
    left: 60px;
    font-size: 35px;
    font-weight: bold;
}

.CoolingText{
    position: absolute;
    top: 1500px;
    left: 260px;
    font-size: 35px;
    font-weight: bold;
}

.CPUText{
    position: absolute;
    top: 1500px;
    left: 500px;
    font-size: 35px;
    font-weight: bold;
}

.GPUText{
    position: absolute;
    top: 1500px;
    left: 700px;
    font-size: 35px;
    font-weight: bold;
}

.MonitorText{
    position: absolute;
    top: 1500px;
    left: 890px;
    font-size: 35px;
    font-weight: bold;
}

.PeripheralsText{
    position: absolute;
    top: 1500px;
    left: 1075px;
    font-size: 35px;
    font-weight: bold;
}

.footer{
    background-color: black;
    color: white;
    padding: 10px;
    width: 98.4%;
    padding: 10px;
    overflow: overlay;
    font-weight: bold;
    display: flex;
    justify-content: space-evenly;
    align-items: center;
    gap: 20px;
}

.FooterFeedback{
    display: inline-block;
    justify-content: left;
    text-align: left;
    align-items: left;
}

.FollowUs{
    display: inline-block;
    text-align: center;
    align-items: center;

}

</style>
<body>
    <div class="BlueNavBar">
    <ul class="NavBar">
        <li><a href="login">Login</a></li>
        <li><a href="basket">Basket</a></li>
        <li><a href="About Us">AboutUs</a></li>
        <li><a href="pcBuilder">PC Builder</a></li>
        <li><a href="wishlist">Wishlist</a></li>
        <li class="searchBar">
        <input type="text" placeholder="Search">  </input>
        </li>
    </ul>
    <div class="techForgeImage">
        <img src="{{ asset('img/techForge.png') }}" alt="TechForge">
    </div>
</div>
    <div class="GreyNavbar">
        <ul class="SecondBar">
            <li> <a href="cases">Cases</a></li>
            <li> <a href="cooling">Cooling</a></li>
            <li> <a href="cpu">CPU</a></li>
            <li> <a href="gpu">GPU</a></li>
            <li> <a href="motherboard">Motherboard</a></li>
            <li> <a href="psu">PSU</a></li>
            <li> <a href="memory">Memory</a></li>
            <li> <a href="monitors">Monitors</a></li>
            <li> <a href="peripherals">Peripherals</a></li>
        </ul>
</div>
<div class="pcSetup">
    <img src="{{ asset('img/pcSetup.jpg') }}" alt="PC Setup">
</div>
<div class="signupText">
    <h1>Please sign up if you do <br> not have an account with us already</h1>
    <p>Having an account will allow you to save items to basket and create wishlists</p>
    <div class="signupForm">
        <div class="formHeader">
            <h2>Sign up with us</h2>
            <small> Please provivde the required details below </small>
        </div>
    <input type="text" placeholder="Full Name">
    <input type="text" placeholder="Email">
    <input type="text" placeholder="Password">
    <button>Submit</button>
    </div>
    </div>
<div class="whiteTechForgeImg">
<img src="{{asset('img/whiteTechForge.png')}}" alt="techforge">
</div>
</div>
    <div class="BestSellers">
        <h1>Best Sellers</h1>
        <div class="NicePcImg">
            <figure>
        <img src="{{'img/NicePc.jpg'}}" alt="pc">
        <figcaption>Nice PC</figcaption>
        <div class="NicePcrating">
            <i class="fas fa-star starred"></i>
            <i class="fas fa-star starred"></i>
            <i class="fas fa-star starred"></i>
            <i class="fas fa-star starred"></i>
            <i class="far fa-star starred"></i>
        </div>
        <button class="SeeMore">See more</button>
        </figure>
        <figure>
        <img src="{{'img/ExtremePc.png'}}" alt="extremePc">
        <figcaption>Extreme Prebuilt</figcaption>
        <div class="ExtremePcrating">
            <i class="fas fa-star starred"></i>
            <i class="fas fa-star starred"></i>
            <i class="fas fa-star starred"></i>
            <i class="fas fa-star starred"></i>
            <i class="far fa-star starred"></i>
        </div>
        <button class="SeeMore">See more</button>
        </figure>
        <figure>
        <img src="{{'img/NicerPc.jpg'}}" alt="NicerPc">
        <figcaption>Nicer Prebuilt</figcaption>
        <div class="NicerPCrating">
            <i class="fas fa-star starred"></i>
            <i class="fas fa-star starred"></i>
            <i class="fas fa-star starred"></i>
            <i class="far fa-star starred"></i>
            <i class="far fa-star starred"></i>
        </div>
        <button class="SeeMore">See more</button>
        </figure>
        </div>
    </div>
    <footer class="footer">
        <div class="FooterFeedback">
            Give us your feedback
            <p><a href="mailto:someone@example.com">DefinitelyTechForge@gmail.com</a></p>
        </div>
         <div class="FollowUs">
            Follow us on social media
            <p><a class="fab fa-facebook" href="https://www.facebook.com"></a> Facebook</p>
            <p><a class="fab fa-twitter" href="https://www.twitter.com"></a> Twitter</p>
            <p><a class="fab fa-instagram" href="https://www.instagram.com"></a> Instagram</p>
        </div>
        <div class="PaymentMethods">
            We accept the following payment methods
            <p><i class="fab fa-cc-visa"> </i> Visa</p>
            <p><i class="fab fa-cc-mastercard"></i> MasterCard</p>
            <p><i class="fab fa-cc-paypal"></i> Paypal</p>
        </div>
    </footer>
    </body>
    </html>




