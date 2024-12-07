import React, { useCallback } from 'react';
import { createRoot } from 'react-dom/client';
import Product from './Product';
import Sidebar from './Sidebar';
import { MantineProvider, Flex, Stack, Title } from '@mantine/core';
import { theme } from '../mantine';

function ProductsList(props) {
  const [products, setProducts] = React.useState(JSON.parse(props.products));
  const [filteredProducts, setFilteredProducts] = React.useState([]);
  const [selectedCategory, setSelectedCategory] = React.useState('All');
  const [priceRange, setPriceRange] = React.useState([10, 5000]); // Default price range

  React.useEffect(() => {
    setFilteredProducts(products);
  }, []);

  // Filter products based on category and price range
  const filterProducts = useCallback((category, range) => {
    setFilteredProducts(
      products.filter((product) => {
        const matchescategory =
          category === 'All' ||
          product.categories.some((cat) => cat.name === category);
        const matchesprice =
          product.price >= range[0] && product.price <= range[1];
        return matchescategory && matchesprice;
      })
    );
  }, [selectedCategory, products])

  const handleCategoryChange = (category) => {
    setSelectedCategory(category);
    filterProducts(category, priceRange);
  };

  // Handler for price range change
  const handlePriceRangeChange = (range) => {
    setPriceRange(range);
    filterProducts(selectedCategory, range);
  };

  return (
    <MantineProvider theme={theme}>
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
          selectedCategory={selectedCategory}
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
  )
}

export default ProductsList;

const rootElement = document.getElementById('products');
const root = createRoot(rootElement);

root.render(<ProductsList {...Object.assign({}, rootElement.dataset)} />);
