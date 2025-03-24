/********************************
Developer: Mihail Vacarciuc , Robert Oros
University ID: 230238428, 230237144
********************************/

// THIS IS THE SIDEBAR COMPONENT FOR THE DASHBOARD

//
// THIS COMPONENT USES MANTINE MAKE SURE THE COMPONENT HAS ACCESS TO MANTINE PROVIDER!!!!
//

import { Stack, RangeSlider, Title, Checkbox } from '@mantine/core'
import { Stars } from '../components/Stars'

import React, { useState, useEffect } from 'react';

export default function Sidebar() {
  const toggleSidebarRef = React.useRef(null);
  const [windowWidth, setWindowWidth] = useState(typeof window !== 'undefined' ? window.innerWidth : 960);
  const isMobile = windowWidth < 960;
  
  const links = [
    { name: 'My Profile', href: '/dashboard' },
    { name: 'My Orders', href: '/dashboard/orders' },
    { name: 'My Cart', href: '/basket' },
    { name: 'Contact Us', href: '/contact' },
  ];

  useEffect(() => {
    const handleResize = () => {
      setWindowWidth(window.innerWidth);
    };

    window.addEventListener('resize', handleResize);
    
    // Clean up the event listener
    return () => {
      window.removeEventListener('resize', handleResize);
    };
  }, []);

  // Close sidebar when clicking outside on mobile
  useEffect(() => {
    const handleClickOutside = (event) => {
      if (isMobile && 
          toggleSidebarRef.current && 
          toggleSidebarRef.current.checked && 
          !event.target.closest('.sidebar-container')) {
        toggleSidebarRef.current.checked = false;
      }
    };

    document.addEventListener('mousedown', handleClickOutside);
    
    return () => {
      document.removeEventListener('mousedown', handleClickOutside);
    };
  }, [isMobile]);

  // Prevent body scrolling when mobile sidebar is open
  useEffect(() => {
    const handleSidebarToggle = () => {
      if (isMobile && toggleSidebarRef.current) {
        document.body.style.overflow = toggleSidebarRef.current.checked ? 'hidden' : '';
      }
    };

    const checkbox = toggleSidebarRef.current;
    if (checkbox) {
      checkbox.addEventListener('change', handleSidebarToggle);
      return () => checkbox.removeEventListener('change', handleSidebarToggle);
    }
  }, [isMobile]);

  return (
    <div className="relative">
      {/* Hamburger Menu - Only visible on mobile */}
      <input 
        type="checkbox" 
        id="sidebarHamburger" 
        className="peer hidden" 
        ref={toggleSidebarRef} 
      />
      <label 
        htmlFor="sidebarHamburger" 
        className="cursor-pointer top-80 left-4 z-30 peer-checked:hidden lg:hidden"
      >
	<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" className="lucide lucide-settings-2"><path d="M20 7h-9"/><path d="M14 17H5"/><circle cx="17" cy="17" r="3"/><circle cx="7" cy="7" r="3"/></svg>
      </label>
      
      {/* Sidebar */}
      <div className={`
        sidebar-container 
        bg-white
        pt-7 px-6 md:px-10 lg:px-14 
        gap-7 
        h-screen 
        transition-all duration-300 
        z-20
        ${isMobile ? 
          'fixed inset-0 w-full peer-checked:translate-x-0 translate-x-[-100%] overflow-y-auto' : 
          'sticky top-0 w-64 md:w-72 lg:w-80 rounded-md'}
      `}>
        {/* Close button - Only visible on mobile */}
        <button 
          onClick={() => toggleSidebarRef.current.click()} 
          className="absolute top-4 right-4 lg:hidden"
        >
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <path d="M12 21a9 9 0 0 0 9 -9a9 9 0 0 0 -9 -9a9 9 0 0 0 -9 9a9 9 0 0 0 9 9z" />
            <path d="M9 8l6 8" />
            <path d="M15 8l-6 8" />
          </svg>
        </button>
        
        {/* Title */}
        <h2 className="text-2xl font-bold mb-6 mt-8 lg:mt-0">Dashboard</h2>
        
        {/* Main navigation links */}
        <nav className="flex flex-col space-y-6 lg:space-y-4">
          {links.map((link, i) => (
            <a 
              key={i}
              href={link.href}
              className="relative text-xl lg:text-lg hover:text-main-accent transition-colors duration-300 
                         before:content-[''] before:absolute before:h-[2px] before:w-full 
                         before:bottom-0 before:left-0 before:bg-main-accent
                         before:scale-x-0 before:transition-all before:ease-linear 
                         before:duration-300 hover:before:scale-x-100"
            >
              {link.name}
            </a>
          ))}
        </nav>
        
        <hr className="my-8 lg:my-6" />
        
        {/* Account links */}
        <div className="flex flex-col space-y-6 lg:space-y-4 pb-10 lg:pb-0">
          <a href="/profile/manage-profile" className="hover:underline text-xl lg:text-lg">
            Change Personal Details
          </a>
          <a href="/profile/manage-profile" className="hover:underline text-xl lg:text-lg">
            Change Password
          </a>
          <a href="/logout" className="hover:underline text-xl lg:text-lg">
            Logout
          </a>
        </div>
      </div>
    </div>
  );
}

