/********************************
Developer: Robert Oros, Mihail Vacarciuc
University ID: 230237144, 230238428
********************************/
import React from "react";
import { createRoot } from "react-dom/client";
import { BrowserRouter, useSearchParams } from "react-router-dom";
import Product from "./Product";
import Sidebar from "./Sidebar";
import { MantineProvider, Flex, Stack, Title, Notification, TextInput, Divider, Pagination } from "@mantine/core";
import { theme } from "../mantine";

function ProductsList(props) {
  const [searchParams, setSearchParams] = useSearchParams();

  // States that control what we send to the server
  const [selectedCategories, setSelectedCategories] = React.useState(
    searchParams.get("categories")?.split(",") || ["All"]
  );
  const [searchQuery, setSearchQuery] = React.useState(searchParams.get("search") || "");
  const [priceRange, setPriceRange] = React.useState([10, 2500]);
  const [showInStockOnly, setShowInStockOnly] = React.useState(false);
  const [successMessage, setSuccessMessage] = React.useState(props.successMessage || null);
  const [pagination, setPagination] = React.useState({
    total: 10,
    current: 1,
    next: 2
  });

  // This will be populated from the server response
  const [products, setProducts] = React.useState([]);

   // Whenever user changes filters, update URL
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

  // Whenever search params change, fetch products from the backend
  React.useEffect(() => {
    // Build the final URL with price range, etc.
    // e.g. /api/products?categories=Electronics&search=iPhone&inStock=true&minPrice=10&maxPrice=2500
    let apiUrl = `/api/products?`;

    const paramsObj = {
      categories: selectedCategories.join(","),
      search: searchQuery.trim(),
      inStock: showInStockOnly ? "true" : "",
      minPrice: priceRange[0],
      maxPrice: priceRange[1],
    };

    // Only include keys that have a value
    for (const [key, value] of Object.entries(paramsObj)) {
      if (value !== "" && value !== undefined && value !== null) {
        apiUrl += `${key}=${encodeURIComponent(value)}&`;
      }
    }

    // Fetch the data
    fetch(apiUrl)
      .then((response) => response.json())
      .then((data) => {
        setProducts(data);
      })
      .catch((error) => {
        console.error("Error fetching products:", error);
      });
  }, [selectedCategories, searchQuery, showInStockOnly, priceRange]);

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

  const onChangePage = async (pageN) => {
    
  }

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
            {products.length === 0 && <NotFound />}
            {products.map((product) => (
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
	  <Pagination total={pagination.total} value={pagination.current} onChange={onChangePage}/>
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
