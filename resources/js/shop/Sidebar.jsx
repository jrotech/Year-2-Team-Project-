import React from "react";
import { Stack, RangeSlider, Title, Checkbox } from "@mantine/core";

export default function Sidebar({ onCategoryChange, onPriceRangeChange, selectedCategory, priceRange, }) {
  const toggleSidebarRef = React.useRef(null);

  const categories = [
    { name: "All" },
    { name: "GPU"},
    { name: "CPU"},
    { name: "RAM"},
    { name: "Motherboard"},
    { name: "Storage"},
    { name: "Cooling" },
  ];

  // Handle category selection
  const handleCategorySelect = (category) => {
    if (onCategoryChange) {
      onCategoryChange(category); // Notify parent
    }
  };
  const handlePriceChange = (value) => {
    if (onPriceRangeChange) {
      onPriceRangeChange(value); // Notify parent of price range changes
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
        <div className="mb-7">
          <Title order={3}>Price</Title>
          <RangeSlider
            minRange={10}
            min={10}
            max={5000}
            step={10}
            value={priceRange}
            onChange={handlePriceChange}
            defaultValue={[10, 5000]}
            marks={[
              { value: 10, label: "10" },
              { value: 5000, label: "5000" },
            ]}
          />
        </div>

        <hr />

        <div>
          <Title order={3}>Availability</Title>
          <Checkbox label="Only show products in stock" />
        </div>

        <hr />

        <Stack className="gap-0">
          <Title order={3}>Categories</Title>
          {categories.map((category) => (
            <Checkbox
              key={category.name}
              checked={selectedCategory === category.name}
              onChange={() => handleCategorySelect(category.name)}
              label={category.name}
            />
          ))}
        </Stack>
      </Stack>
    </div>
  );
}
