import React from 'react';
import { createRoot } from 'react-dom/client';
import Product from './Product'
import Sidebar from './Sidebar'
import { MantineProvider, Flex } from '@mantine/core';
import { theme } from '../mantine';

function ProductsList(props){

	 // Parse products from props
	 const products = JSON.parse(props.products);

	 const [filteredProducts, setFilteredProducts] = React.useState(products); // State for filtered products  // added useState reactHook
   
	 // Handler for filtering products based on category
	 const handleCategoryFilter = (category) => {
	   if (category === 'All') {
		 setFilteredProducts(products); // Show all products
	   } else {
		 setFilteredProducts(products.filter((product) => product.category === category));
	   }
	 };
   
  console.log(props)
  return (
    <MantineProvider theme={theme}>
      <Flex className="max-w-screen justify-between m-24 relative">
	<Flex className="items-center justify-center w-full">
	  <Flex className="gap-20 flex-wrap max-w-[1200px] justify-center">
	 	 {filteredProducts.map((product) => (
              <Product
                key={product.id}
                name={product.name}
                img={product.image}
                rating={product.rating || 0} // Default rating if not present
                price={product.price}
                inStock={product.in_stock}
                wishList={false}
                id={product.id}
              />
            ))}
	  </Flex>
	</Flex>
	<Sidebar />
      </Flex>
    </MantineProvider>
  )
}

export default ProductsList;

const rootElement = document.getElementById('products')
const root = createRoot(rootElement);

root.render(<ProductsList {...Object.assign({}, rootElement.dataset)} />);


