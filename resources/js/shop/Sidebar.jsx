/********************************
Developer: Robert Oros, Mihail Vacarciuc
University ID: 230237144, 230238428
********************************/
import React from "react";
import { Stack, RangeSlider, Title, Checkbox } from "@mantine/core";

export default function Sidebar({
  onCategoryChange,
  onPriceRangeChange,
  onInStockChange,
  selectedCategories,
  priceRange,
  showInStockOnly,
}) {
  const toggleSidebarRef = React.useRef(null);

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

  return (
    <div>
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

      <Stack className="max-w-[500px] min-w-[300px] sm:w-[400px] w-[300px] bg-white rounded-md pt-7 px-14 gap-7 h-screen sticky top-10 max-[960px]:peer-checked:translate-x-[-80%] max-[960px]:translate-x-[100%] transition-all duration-300 max-[960px]:absolute z-20">
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
        </div>

        <hr />

        <div>
          <Title order={3}>Availability</Title>
          <Checkbox
            label="Only show products in stock"
            checked={showInStockOnly}
            onChange={handleInStockToggle}
          />
        </div>

        <hr />

        <Stack className="gap-0">
          <Title order={3}>Categories</Title>
          {categories.map((category) => (
            <Checkbox
              key={category.name}
              checked={selectedCategories.includes(category.name)}
              onChange={() => handleCategorySelect(category.name)}
              label={category.name}
            />
          ))}
        </Stack>
      </Stack>
    </div>
  );
}
