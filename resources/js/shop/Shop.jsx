import React from "react";
import { createRoot } from "react-dom/client";
import { BrowserRouter, useSearchParams } from "react-router-dom";
import Product from "./Product";
import Sidebar from "./Sidebar";
import { MantineProvider, Flex, Stack, Title, Notification, TextInput, Divider } from "@mantine/core";
import { theme } from "../mantine";

function ProductsList(props) {
  const [searchParams, setSearchParams] = useSearchParams();
  const [products] = React.useState(JSON.parse(props.products));
  const [filteredProducts, setFilteredProducts] = React.useState([]);
  const [selectedCategories, setSelectedCategories] = React.useState(
    searchParams.get("categories")?.split(",") || ["All"]
  );
  const [searchQuery, setSearchQuery] = React.useState(searchParams.get("search") || "");
  const [priceRange, setPriceRange] = React.useState([10, 2500]);
  const [showInStockOnly, setShowInStockOnly] = React.useState(false);
  const [successMessage, setSuccessMessage] = React.useState(props.successMessage || null);

  // Sync state with URL search parameters
  React.useEffect(() => {
    const params = new URLSearchParams();
    if (selectedCategories.length > 0) {
      params.set("categories", selectedCategories.join(","));
    }
    if (searchQuery.trim() !== "") {
      params.set("search", searchQuery.trim());
    }
    if (showInStockOnly) {
      params.set("inStock", "true");
    }
    setSearchParams(params);
  }, [selectedCategories, searchQuery, showInStockOnly, setSearchParams]);

  // Apply filtering logic
  React.useEffect(() => {
    const filtered = products.filter((product) => {
      const matchesCategories =
        selectedCategories.includes("All") ||
        product.categories.some((cat) => selectedCategories.includes(cat.name));
      const matchesPrice = product.price >= priceRange[0] && product.price <= priceRange[1];
      const matchesSearch =
        searchQuery === "" || product.name.toLowerCase().includes(searchQuery.toLowerCase());
      const matchesStock = !showInStockOnly || product.in_stock;
      return matchesCategories && matchesPrice && matchesSearch && matchesStock;
    });
    setFilteredProducts(filtered);
  }, [selectedCategories, priceRange, searchQuery, showInStockOnly, products]);

  // Handle search input changes
  const handleSearchChange = (e) => {
    const value = e.target.value;
    setSearchQuery(value);
  };

  const handlePriceRangeChange = (range) => {
    setPriceRange(range);
  };

  const handleCategoryChange = (category) => {
    setSelectedCategories((prev) => {
      if (category === "All") {
        return ["All"];
      } else {
        return prev.includes(category)
          ? prev.filter((cat) => cat !== category)
          : [...prev.filter((cat) => cat !== "All"), category];
      }
    });
  };

  const handleInStockChange = (checked) => {
    setShowInStockOnly(checked);
  };

  return (
    <MantineProvider theme={theme}>
      <Flex className="max-w-screen justify-center m-24 relative gap-20">
        

        {/* Main Content */}
        <Stack className="w-full max-w-[1200px]">
          {/* Success Notification */}
          {successMessage && (
            <Notification
              onClose={() => setSuccessMessage(null)}
              color="teal"
              title="Success"
              className="mb-8"
            >
              {successMessage}
            </Notification>
          )}

          {/* Search Bar */}
          <TextInput
            value={searchQuery}
            onChange={handleSearchChange}
            placeholder="Search products..."
            radius="md"
            size="lg"
            className="mb-8 shadow-sm"
            styles={{
              input: {
                border: "1px solid #d1d5db",
                backgroundColor: "#ffffff",
                fontSize: "1rem",
              },
            }}
          />

          {/* Divider */}
          <Divider size="xs" my="xs" />

          {/* Product List */}
          <Flex className="gap-20 flex-wrap justify-center">
            {filteredProducts.length === 0 && <NotFound />}
            {filteredProducts.map((product) => (
              <Product
                key={product.id}
                name={product.name}
                primary_image={product.primary_image}
                rating={product.rating || 0}
                price={product.price}
                inStock={product.in_stock}
                wishList={false}
                id={product.id}
              />
            ))}
          </Flex>
        </Stack>
        {/* Sidebar */}
        <Sidebar
          onCategoryChange={handleCategoryChange}
          onPriceRangeChange={handlePriceRangeChange}
          onInStockChange={handleInStockChange}
          selectedCategories={selectedCategories}
          priceRange={priceRange}
          showInStockOnly={showInStockOnly}
        />
      </Flex>
    </MantineProvider>
  );
}

function NotFound() {
  return (
    <Stack align="center" justify="center" className="mt-10">
      <Title order={3} color="dimmed">No products found</Title>
    </Stack>
  );
}

export default ProductsList;

const rootElement = document.getElementById("products");
const root = createRoot(rootElement);

root.render(
  <BrowserRouter>
    <ProductsList {...Object.assign({}, rootElement.dataset)} />
  </BrowserRouter>
);
