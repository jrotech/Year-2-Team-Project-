import React from "react";
import { Stack, RangeSlider, Title, Checkbox } from "@mantine/core";

export default function Sidebar({ onCategoryChange }) {
  const toggleSidebarRef = React.useRef(null);

  const categories = [
    { name: "All", href: "/" },
    { name: "GPUs", href: "/category1" },
    { name: "CPUs", href: "/category2" },
    { name: "RAM", href: "/category3" },
    { name: "Motherboards", href: "/category4" },
    { name: "Storage", href: "/category5" },
    { name: "Cooling", href: "/category6" },
  ];

  // Handler for checkbox change
  const handleCategoryChange = (name) => {
    if (onCategoryChange) {
      onCategoryChange(name); // Notify parent
    }
  };

  return (
    <div>
      {/* Hamburger */}
      <input
        type="checkbox"
        id="sidebarHamburger"
        className="peer hidden"
        ref={toggleSidebarRef}
      />
      <label
        htmlFor="sidebarHamburger"
        className="cursor-pointer absolute top-[-50px] left-10 peer-checked:hidden"
      >
        {[1, 2, 3].map((_, i) => (
          <span
            key={i}
            className="min-[960px]:hidden block w-8 mb-1 bg-black h-1 origin-top-right transition-transform"
          ></span>
        ))}
      </label>

      {/* Sidebar */}
      <Stack className="max-w-[500px] min-w-[300px] sm:w-[400px] w-[300px] bg-white rounded-md pt-7 px-14 gap-7 h-screen sticky top-10 max-[960px]:peer-checked:translate-x-[-80%] max-[960px]:translate-x-[100%] transition-all duration-300 max-[960px]:absolute z-20">
        <button
          onClick={() => toggleSidebarRef.current.click()}
          className="min-[960px]:hidden"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="35"
            height="35"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            strokeWidth="2"
            strokeLinecap="round"
            strokeLinejoin="round"
            className="icon icon-tabler icons-tabler-outline icon-tabler-xbox-x"
          >
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <path d="M12 21a9 9 0 0 0 9 -9a9 9 0 0 0 -9 -9a9 9 0 0 0 -9 9a9 9 0 0 0 9 9z" />
            <path d="M9 8l6 8" />
            <path d="M15 8l-6 8" />
          </svg>
        </button>

        {/* Price Filter */}
        <div className="mb-7">
          <Title order={3}>Price</Title>
          <RangeSlider
            minRange={10}
            min={10}
            max={5000}
            step={10}
            defaultValue={[10, 5000]}
            marks={[
              { value: 10, label: "10" },
              { value: 5000, label: "5000" },
            ]}
          />
        </div>

        <hr />

        {/* Availability Filter */}
        <div>
          <Title order={3}>Availability</Title>
          <Checkbox label="Only show products in stock" />
        </div>

        <hr />

        {/* Categories */}
        <Stack className="gap-0">
          <Title order={3}>Categories</Title>
          {categories.map((category) => (
            <Checkbox
              key={category.name}
              defaultChecked={category.name === "All"} // "All" is checked by default
              label={category.name}
              onChange={() => handleCategoryChange(category.name)} // Handle category change
            />
          ))}
        </Stack>
      </Stack>
    </div>
  );
}
