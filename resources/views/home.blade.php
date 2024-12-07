<!--/ 
    developer : Amen Alhousieni
    university id : 230237878
    fucntion : my aim to do the fisrt half of code for home page till signiup blocks
/-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.bunny.net">
    @vite(['resources/css/app.css', 'resources/js/app.js','resources/js/shop/page.js'])
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
    color: #FFD700; /* Gold color for stars */
    margin-top: 5px;
    font-size: 16px;
}
.NicePcrating i {
    margin: 0 2px;
}
.ExtremePcrating {
    color: #FFD700; /* Gold color for stars */
    margin-top: 5px;
    font-size: 16px;
}
.ExtremePcrating i {
    margin: 0 2px;
}
.far.fa-star {
    color: #ccc; /* Gray color for empty stars */
}
.NicerPCrating {
    color: #FFD700; /* Gold color for stars */
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
</style>
<body>
  <div id="nav"></div>
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
<div class="Categories">
    <h1>Categories</h1>
    <div class="CategoryImages">
    </div>
</div>
</body>
</html>




