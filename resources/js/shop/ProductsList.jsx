import React from 'react';
import { createRoot } from 'react-dom/client';
import Product from './Product'
import Sidebar from './Sidebar'
import { createTheme, MantineProvider, Flex } from '@mantine/core';
const theme = createTheme({
  colors: {
    main: [
      "#010035",
      "#1A1947",
      "#1A1947",
      "#1A1947",
      "#1A1947",
      "#1A1947",
      "#1A1947",
      "#1A1947",
      "#1A1947",
      "#1A1947",
    ],
  },
  primaryColor: "main",
});

function ProductsList(props){
  console.log(props)
  return (
    <MantineProvider theme={theme}>
      <Flex className="max-w-screen justify-between m-24 ">
	<Flex className="items-center justify-center w-full">
	  <Flex className="gap-20 flex-wrap max-w-[1200px]">
	    {
	    Array.from({length: 100}, (_,i) => <Product key={i}
							name={"Nvidia Gforce Rtx 3070 TI"}
							img={"https://www.nvidia.com/content/dam/en-zz/Solutions/geforce/ampere/rtx-3070/geforce-rtx-3070-shop-600-p@2x.png"}
							price={599.99}
							inStock={false}
							wishList={false}
							id={i}
					       />)
	    }
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


