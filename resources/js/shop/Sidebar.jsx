/********************************
Developer: Robert Oros, Mihail Vacarciuc
University ID: 230237144, 230238428
********************************/
import { Stack, RangeSlider, Title, Checkbox, Flex, NumberInput } from '@mantine/core'
import { Stars } from '../components/Stars'

import React, { useState, useEffect } from 'react';

export default function Sidebar({onCategoryChange,
  onPriceRangeChange,
  onInStockChange,
  selectedCategories,
  priceRange,
  showInStockOnly,
}) {
  const toggleSidebarRef = React.useRef(null);
  const [windowWidth, setWindowWidth] = useState(typeof window !== 'undefined' ? window.innerWidth : 960);
  const isMobile = windowWidth < 960;

  const categories = [
    { name: "All" },
    { name: "GPU" },
    { name: "CPU" },
    { name: "RAM" },
    { name: "Motherboard" },
    { name: "Storage" },
    { name: "Cooling" },
  ];

  const handleCategorySelect = (category) => {
    if (onCategoryChange) {
      onCategoryChange(category);
    }
  };

  const handlePriceChange = (value) => {
    if (onPriceRangeChange) {
      onPriceRangeChange(value);
    }
  };

  const handleInStockToggle = (e) => {
    if (onInStockChange) {
      onInStockChange(e.target.checked);
    }
  };
  
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
        <div className="mb-7">
          <Title order={3}>Price</Title>
          <RangeSlider
            minRange={10}
            min={10}
            max={2500}
            step={10}
            value={priceRange}
            onChange={handlePriceChange}
            defaultValue={[10, 2500]}
            marks={[
              { value: 10, label: "10" },
              { value: 2500, label: "2500" },
            ]}
          />
	  <Flex mt="40" gap="10">
    <NumberInput
      value={priceRange[0]}
      label="Min price"
      rightSection={<></>}
      onChange={(value) => handlePriceChange([value, priceRange[1]])}
      placeholder="Input placeholder"
    />
    <NumberInput
      value={priceRange[1]}
      label="Max Price"
      onChange={(value) => handlePriceChange([priceRange[0], value])}
      rightSection={<></>}
      placeholder="Input placeholder"
    />
	  </Flex>
        </div>

        <hr />
	</nav>
        
        <Stack className="my-5">
          <Title order={3}>Availability</Title>
	  
	    <Flex justify="space-between">
	      <Title order={5} className="">Only Show In Stock Products</Title>
          <Checkbox
            checked={showInStockOnly}
            onChange={handleInStockToggle}
	    size="lg"
          />
	    </Flex>

        </Stack>

        <hr />

        <Stack className="gap-0">
          <Title order={3}>Categories</Title>
          {categories.map((category, index) => (
	    <Flex justify="space-between" key={index}>
	      <Title order={5} className="">{category.name}</Title>
              <Checkbox
		key={category.name}
		    checked={selectedCategories.includes(category.name)}
		    onChange={() => handleCategorySelect(category.name)}
		size="lg"
              />
	    </Flex>
          ))}
        </Stack>


      </div>
    </div>
  );
}

