import React from "react";
import { createRoot } from "react-dom/client";
import { BrowserRouter, useSearchParams } from "react-router-dom";
import Product from "./Product";
import Sidebar from "./Sidebar";
import { MantineProvider, Flex, Stack, Title, Notification } from "@mantine/core";
import { theme } from "../mantine";

function ProductsList(props) {

  const [searchParams, setSearchParams] = useSearchParams();
  const [products, setProducts] = React.useState(JSON.parse(props.products));
  const [filteredProducts, setFilteredProducts] = React.useState([]);
  // Initialize selectedCategories from URL query params directly
  const [selectedCategories, setSelectedCategories] = React.useState(
    searchParams.get("categories")?.split(",") || ["All"]
  );
  
  const [priceRange, setPriceRange] = React.useState([10, 2500]);
  const [successMessage, setSuccessMessage] = React.useState(props.successMessage || null);

  // Initially populate filteredProducts with all products
  React.useEffect(() => {
    setFilteredProducts(products);
  }, [products]);

  // Update URL query params whenever selectedCategories changes
  React.useEffect(() => {
    setSearchParams({
      categories: selectedCategories.join(","),
    });
  }, [selectedCategories, setSearchParams]);

  // Filter products based on categories and price range
  React.useEffect(() => {
    const filtered = products.filter((product) => {
      const matchesCategories =
        selectedCategories.includes("All") ||
        product.categories.some((cat) => selectedCategories.includes(cat.name));
      const matchesPrice =
        product.price >= priceRange[0] && product.price <= priceRange[1];
      return matchesCategories && matchesPrice;
    });
    setFilteredProducts(filtered);
  }, [selectedCategories, priceRange, products]);

  const handleCategoryChange = (category) => {
    setSelectedCategories((prevCategories) => {
      let updatedCategories;
      if (category === "All") {
        updatedCategories = ["All"];
      } else {
        updatedCategories = prevCategories.includes(category)
          ? prevCategories.filter((cat) => cat !== category)
          : [...prevCategories.filter((cat) => cat !== "All"), category];
      }
      return updatedCategories;
    });
  };

  const handlePriceRangeChange = (range) => {
    setPriceRange(range);
  };

  return (
    <MantineProvider theme={theme}>
      {successMessage && (
        <Notification
          onClose={() => setSuccessMessage(null)}
          color="teal"
          title="Success"
        >
          {successMessage}
        </Notification>
      )}
      <Flex className="max-w-screen justify-between m-24 relative">
        <Flex className="items-center justify-center w-full">
          <Flex className="gap-20 flex-wrap max-w-[1200px] justify-center">
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
        </Flex>
        <Sidebar
          onCategoryChange={handleCategoryChange}
          onPriceRangeChange={handlePriceRangeChange}
          selectedCategories={selectedCategories}
          priceRange={priceRange}
        />
      </Flex>
    </MantineProvider>
  );
}

function NotFound() {
  return (
    <Stack>
      <Title>No products found</Title>
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
