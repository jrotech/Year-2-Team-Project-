import { COMPANY_NAME } from "../constants";
import React from 'react';
import { createRoot } from 'react-dom/client';

function NavBar() {
  const links = [
    {
      name:"home",
      href:"/"
    },
    {
      name:"about",
      href:"/about"
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
    <nav className="absolute top-0 z-[10000] box-border w-screen text-white">
      <div className="flex items-center m-auto max-w-screen-xl justify-between p-4 bg-transparent flex-wrap">
        <a href="/" className="font-semibold uppercase mx-5 cursor-pointer md:block">
          <h1 className="">{COMPANY_NAME}</h1>
        </a>

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
                  className="relative p-4 text-lg hover:text-main-accent transition-color duration-300 font-normal before:content-[''] before:absolute before:h-[2px] before:w-full before:bottom-0 before:left-0 before:right-0 before:bg-main-primary before:scale-x-0 before:transition-all before:ease-linear before:duration-300 hover:before:scale-x-100"
                >
                  {/*@ts-ignore*/}
                  <a href={a.href}>{a.name}</a>
                </li>
              );
            })}
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

export default NavBar;

const rootElement = document.getElementById('nav')
const root = createRoot(rootElement);

root.render(<NavBar />);
