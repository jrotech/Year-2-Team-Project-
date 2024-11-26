import { COMPANY_NAME } from "../constants";
import React from 'react';
import { createRoot } from 'react-dom/client';

function NavWrapp(){
  return (
    <div className="relative top-0 z-[1] box-border w-screen text-white">
      <NavBar/>
      <Categories/>
    </div>
  )
}

function NavBar() {
  const links = [
    {
      name:"home",
      href:"/"
    },
    {
      name:"shop",
      href:"/shop"
    },
    {
      name:"services",
      href:"/services"
    },
    {
      name:"contact",
      href:"/contact"
    }
  ];
  return (
    <nav className="bg-main-primary">
      <div className="flex items-center m-auto  justify-between p-4 bg-transparent flex-wrap">
        <a href="/" className="font-semibold uppercase mx-5 cursor-pointer md:block">
	  <img alt="" src="images/logo.png" className="w-44 max-[450px]:w-28" />
        </a>
      <SearchBar />
        <div className="bg-none border-none outline-none cursor-pointer mx-5 select-none appearance-none z-1 flex flex-col ">
          {/* hamburger */}
          <input type="checkbox" id="hamburgercheckbox" className="peer hidden" />
          <label htmlFor="hamburgercheckbox" className="cursor-pointer">
            {[1, 2, 3].map((_, i) => (
              <span
                key={i}
                className="md:hidden  block w-8 mb-1 bg-white h-1 origin-top-right transition-transform"
              ></span>
            ))}
          </label>
          <ul className="items-baseline flex max-[767px]:peer-checked:translate-x-0 max-[767px]:translate-x-[-100%] transition-all duration-300 max-[767px]:absolute max-[767px]:flex-col max-[767px]:h-screen max-[767px]:bg-main-gray max-[767px]:w-1/2 max-[767px]:left-0 max-[767px]:top-[100%] z-20 max-[767px]:peer-checked:bg-main-dark">
            {links.map(a => {
              return (
                <li
                  key={a.name}
                  className="relative p-4 text-lg hover:text-main-accent transition-color duration-300 font-normal before:content-[''] before:absolute before:h-[2px] before:w-full before:bottom-0 before:left-0 before:right-0 before:bg-main-accent before:scale-x-0 before:transition-all before:ease-linear before:duration-300 hover:before:scale-x-100 capitalize"
                >
                  <a href={a.href}>{a.name}</a>
                </li>
              );
            })}

	    <li className="font-normal hover:text-main-accent transition-color duration-300">
	     <a href='/cart'>
        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  strokeWidth="2"  strokeLinecap="round"  strokeLinejoin="round"  className="icon icon-tabler icons-tabler-outline icon-tabler-shopping-cart"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M17 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M17 17h-11v-14h-2" /><path d="M6 5l14 1l-1 7h-13" /></svg>
	    </a>
      </li>
            <li className="p-4 font-normal hover:text-main-accent transition-color duration-300">
              {false ? (
                <a href="/dashboard">Dashboard</a>
              ) : (
                <a
                  href="/login"
                  className="py-3 text-center px-4 bg-main-primary text-white rounded-md font-semibold transition-color duration-300 w-20 hover:bg-main-accent"
                >
                  Login
                </a>
              )}
            </li>
          </ul>
        </div>
      </div>
    </nav>
  );
}

function SearchBar(){
  return (
    <div className="flex items-center justify-center flex-shrink">
      <input type="text" placeholder="Search" className="border-2 border-gray-300 bg-white h-10 sm:w-80 px-5 my-2 max-[540px]:w-32 rounded-full text-sm focus:outline-none text-center text-black" />
    </div>
  )
}

function Categories(){
  const categories = [
		{
			name:"cases",
			href:"/category1"
		},
		{
			name:"PC components",
			href:"/category2"
		},
		{
			name:"Peripherals",
			href:"/category3"
		},
		{
			name:"monitors",
			href:"/category4"
		},
	];
  return (
    <div className="bg-[#263238]">
      <ul className="flex items-center justify-center flex-wrap">
	{categories.map(a => {
	  return (
	    <li key={a.name} className="p-4 text-lg hover:text-main-accent transition-color duration-300 font-normal">
	      <a href={a.href}>{a.name}</a>
	    </li>
	  );
	})}
      </ul>
    </div>
  )
}


export default NavWrapp;

const rootElement = document.getElementById('nav')
const root = createRoot(rootElement);

root.render(<NavWrapp />);


