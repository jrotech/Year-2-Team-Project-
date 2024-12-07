import React from 'react';
import { createRoot } from 'react-dom/client';
import { MantineProvider, Flex, Stack, Title } from '@mantine/core';
import { theme } from '../mantine';
import BasketProduct from './Product';
import Sidebar from './Sidebar';

function Basket(props){
  console.log(props)
  return (
    <MantineProvider theme={theme}>
      <Flex className="max-w-screen justify-center relative mt-28" gap="30">
	<Stack className="">
	  {
	    Array.from({length: 5}).map((_, i) => (
	      <BasketProduct key={i} name="RAM Corsair Vengeance RGB DDR5 32GB (2x16GB) 6400MHz CL36 Black" quantity={1} price={299.99}
			     img_url="https://assets.corsair.com/image/upload/c_pad,q_85,h_1100,w_1100,f_auto/products/Memory/vengeance-rgb-ddr5-blk-config/Gallery/Vengeance-RGB-DDR5-2UP-BLACK_01.webp"
			     description="Diam ut venenatis tellus in metus vulputate eu scelerisque felis imperdiet proin fermentum leo vel orci porta non pulvinar. Natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus mauris!"
			     category="Memory"
	      />
	      
	    ))
	  }
	</Stack>
	<Sidebar/>
      </Flex>
    </MantineProvider>
  )
}

export default Basket;

const rootElement = document.getElementById('basket')
const root = createRoot(rootElement);

root.render(<Basket {...Object.assign({}, rootElement.dataset)} />);


