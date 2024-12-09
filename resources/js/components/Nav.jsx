import { COMPANY_NAME } from "../constants";
import React from 'react';
import { BrowserRouter, useSearchParams } from "react-router-dom";
import { createRoot } from 'react-dom/client';
import { useState, useEffect } from 'react'
function NavWrapp() {
  const [isAuthenticated, setIsAuthenticated] = useState(false);

  useEffect(() => {
    async function checkAuth() {
      try {
        const response = await fetch("/api/auth-status", {
          credentials: "include", // Include cookies
        });
        const data = await response.json();
        setIsAuthenticated(data.isAuthenticated);
      } catch (error) {
        console.error("Failed to check auth status", error);
      }
    }
    checkAuth();
  }, []);

  const isShopPage = window.location.pathname === "/shop"; // Check if current page is /shop

  return (
    <div className="relative top-0 z-[1] box-border w-screen text-white">
      <NavBar isAuthenticated={isAuthenticated} isShopPage={isShopPage} />
      <Categories />
    </div>
  );
}

function NavBar({ isAuthenticated, isShopPage }) {
  const links = [
    { name: "home", href: "/" },
    { name: "shop", href: "/shop" },
    { name: "services", href: "/services" },
    { name: "contact", href: "/contact" },
  ];

  return (
    <nav className="bg-main-primary">
      <div className="flex items-center m-auto justify-between p-4 bg-transparent flex-wrap">
        <a href="/" className="font-semibold uppercase mx-5 cursor-pointer md:block">
          <img alt="" src="/images/logo.png" className="w-44 max-[450px]:w-28" />
        </a>
        {!isShopPage && <SearchBar />} {/* Render SearchBar only if not on /shop page */}
        <div className="bg-none border-none outline-none cursor-pointer mx-5 select-none appearance-none z-1 flex flex-col">
          <input type="checkbox" id="hamburgercheckbox" className="peer hidden" />
          <label htmlFor="hamburgercheckbox" className="cursor-pointer">
            {[1, 2, 3].map((_, i) => (
              <span
                key={i}
                className="md:hidden block w-8 mb-1 bg-white h-1 origin-top-right transition-transform"
              ></span>
            ))}
          </label>
          <ul className="items-baseline flex max-[767px]:peer-checked:translate-x-0 max-[767px]:translate-x-[-100%] transition-all duration-300 max-[767px]:absolute max-[767px]:flex-col max-[767px]:h-screen max-[767px]:bg-main-gray max-[767px]:w-1/2 max-[767px]:left-0 max-[767px]:top-[100%] z-20 max-[767px]:peer-checked:bg-main-dark">
            {links.map((link) => (
              <li
                key={link.name}
                className="relative p-4 text-lg hover:text-main-accent transition-color duration-300 font-normal before:content-[''] before:absolute before:h-[2px] before:w-full before:bottom-0 before:left-0 before:right-0 before:bg-main-accent before:scale-x-0 before:transition-all before:ease-linear before:duration-300 hover:before:scale-x-100 capitalize"
              >
                <a href={link.href}>{link.name}</a>
              </li>
            ))}
            <li className="font-normal hover:text-main-accent transition-color duration-300">
              <a href="/basket">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="24"
                  height="24"
                  viewBox="0 0 24 24"
                  fill="none"
                  stroke="currentColor"
                  strokeWidth="2"
                  strokeLinecap="round"
                  strokeLinejoin="round"
                  className="icon icon-tabler icons-tabler-outline icon-tabler-shopping-cart"
                >
                  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                  <path d="M6 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                  <path d="M17 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                  <path d="M17 17h-11v-14h-2" />
                  <path d="M6 5l14 1l-1 7h-13" />
                </svg>
              </a>
            </li>
            <li className="p-4 font-normal hover:text-main-accent transition-color duration-300">
              {isAuthenticated ? (
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

function SearchBar() {
  const [searchText, setSearchText] = React.useState("");

  const handleSearchChange = (e) => {
    setSearchText(e.target.value);
  };

  const handleSearchSubmit = (e) => {
    e.preventDefault();
    if (searchText.trim()) {
      window.location.href = `/shop?search=${encodeURIComponent(searchText)}`;
    }
  };

  return (
    <form onSubmit={handleSearchSubmit} className="flex items-center justify-center flex-shrink">
      <input
        type="text"
        placeholder="Search"
        value={searchText}
        onChange={handleSearchChange}
        className="border-2 border-gray-300 bg-white h-10 sm:w-80 px-5 my-2 max-[540px]:w-32 rounded-full text-sm focus:outline-none text-center text-black"
      />
      <button type="submit" className="hidden">Submit</button>
    </form>
  );
}

function Categories() {
  const categories = [
    { name: "GPUs", href: "/shop?categories=GPU" },
    { name: "CPUs", href: "/shop?categories=CPU" },
    { name: "RAM", href: "/shop?categories=RAM" },
    { name: "Motherboards", href: "/shop?categories=Motherboard" },
    { name: "Storage", href: "/shop?categories=Storage" },
    { name: "Cooling", href: "/shop?categories=Cooling" },
  ];

  return (
    <div className="bg-[#263238]">
      <ul className="flex items-center justify-center flex-wrap">
        {categories.map((category) => (
          <li
            key={category.name}
            className="p-4 text-lg hover:text-main-accent transition-color duration-300 font-normal"
          >
            <a href={category.href}>{category.name}</a>
          </li>
        ))}
      </ul>
    </div>
  );
}


export default NavWrapp;

const rootElement = document.getElementById('nav')
const root = createRoot(rootElement);

root.render(<BrowserRouter><NavWrapp /></BrowserRouter>);


