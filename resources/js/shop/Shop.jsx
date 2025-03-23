import React from "react";
import { createRoot } from "react-dom/client";
import { BrowserRouter, useSearchParams } from "react-router-dom";
import { Center, Pagination } from "@mantine/core";
import Product from "./Product";
import Sidebar from "./Sidebar";
import {MantineProvider,Flex,Stack,Title,Notification,TextInput,Divider,} from "@mantine/core";
import { theme } from "../mantine";

// Import the useDebounce hook
import { useDebounce } from "use-debounce";

function ProductsList(props) {
  const [searchParams, setSearchParams] = useSearchParams();

  // States
  const [selectedCategories, setSelectedCategories] = React.useState(
    searchParams.get("categories")?.split(",") || ["All"]
  );
  const [searchQuery, setSearchQuery] = React.useState(
    searchParams.get("search") || ""
  );
  const [priceRange, setPriceRange] = React.useState([10, 2500]);
  const [showInStockOnly, setShowInStockOnly] = React.useState(false);
  const [successMessage, setSuccessMessage] = React.useState(
    props.successMessage || null
  );

  // Create debounced versions of your search and price range
  const [debouncedSearchQuery] = useDebounce(searchQuery, 100);
  const [debouncedPriceRange] = useDebounce(priceRange, 100);

  // Pagination: keep track of the current page and total pages
  const [currentPage, setCurrentPage] = React.useState(1);
  const [totalPages, setTotalPages] = React.useState(1);

  // Products from server
  const [products, setProducts] = React.useState([]);

  React.useEffect(() => {
    console.log("Selected categories changed:", selectedCategories);
    const params = new URLSearchParams();
    params.set("page", 1);
  }, [selectedCategories]);

  // Update URL whenever filters or page change
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
    params.set("page", currentPage);

    setSearchParams(params);
  }, [selectedCategories, searchQuery, showInStockOnly, currentPage, setSearchParams]);

  // Fetch from API (use debounced values in the query)
  React.useEffect(() => {
    let apiUrl = `/api/products?`;

    const paramsObj = {
      categories: selectedCategories.join(","),
      search: debouncedSearchQuery.trim(),     
      inStock: showInStockOnly ? "true" : "",
      minPrice: debouncedPriceRange[0],         
      maxPrice: debouncedPriceRange[1],         
      page: currentPage,
    };

    // Build final query
    for (const [key, value] of Object.entries(paramsObj)) {
      if (value !== "" && value !== undefined && value !== null) {
        apiUrl += `${key}=${encodeURIComponent(value)}&`;
      }
    }

    fetch(apiUrl)
      .then((response) => response.json())
      .then((data) => {
        // 'data' is the Laravel paginator object
        setProducts(data.data); // The actual products
        setCurrentPage(data.current_page);
        setTotalPages(data.last_page);
      })
      .catch((error) => {
        console.error("Error fetching products:", error);
      });
  }, [
    selectedCategories,
    debouncedSearchQuery,    
    showInStockOnly,
    debouncedPriceRange,    
    currentPage,
  ]);

  // Handlers
  const handleSearchChange = (e) => setSearchQuery(e.target.value);
  const handlePriceRangeChange = (range) => setPriceRange(range);

  const handleCategoryChange = (category) => {
    setSelectedCategories((prev) => {
      if (category === "All") {
        return ["All"];
      }
      return prev.includes(category)
        ? prev.filter((cat) => cat !== category)
        : [...prev.filter((cat) => cat !== "All"), category];
    });
  };

  const handleInStockChange = (checked) => {
    setShowInStockOnly(checked);
  };

  // Mantine Pagination calls onChange(pageNumber)
  const onChangePage = (page) => {
    setCurrentPage(page);
  };

  return (
    <MantineProvider theme={theme}>
      <Flex className="max-w-screen justify-center m-24 relative gap-20">
        {/* Main Content */}
        <Stack className="w-full max-w-[1200px]">
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

          <Divider size="xs" my="xs" />

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

          {/* Pagination Component */}
          <Center mt="50">
            <Pagination
              total={totalPages}
              page={currentPage}
              onChange={onChangePage}
              size="xl"
            />
          </Center>
        </Stack>

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
      <Title order={3} color="dimmed">
        No products found
      </Title>
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
