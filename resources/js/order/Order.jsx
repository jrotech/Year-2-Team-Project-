import React from 'react';
import { createRoot } from 'react-dom/client';
import Sidebar from '../components/Sidebar'
import { MantineProvider, Flex, Stack, Title, Text } from '@mantine/core';
import { theme } from '../mantine';
import Product from './Product';

function Order(props){
  console.log(props)
  return (
    <MantineProvider theme={theme}>
      <Flex className="max-w-screen justify-between m-24 relative">
	<Flex className="items-center justify-center w-full">
	  <Stack className="gap-40 flex-wrap justify-center mx-5">

	    <Title order={1}>Order Date: 12/02/22</Title>
	    <Stack className="bg-white rounded-md p-10" gap="10">
	      <Flex gap="50">
		<Stack gap="10">
		 <Title order={5}>Order Number: #123456</Title>
		 <Text order={6}>Order Status: Delivered</Text>
		 <Text order={3}>Order Total: $599.99</Text>
		</Stack>
		<Stack align="center" className="cursor-pointer">
		  <Text order={6}>Download Invoice</Text>
		  <svg  xmlns="http://www.w3.org/2000/svg"  width="40"  height="40"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-download"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" /><path d="M7 11l5 5l5 -5" /><path d="M12 4l0 12" /></svg>
		</Stack>
		<Stack>
		  <Title order={3}>Shipping Address:</Title>
		  <p>1234 Main St</p>
		  <p>San Francisco, CA 94123</p>
		</Stack>
	      </Flex>
	    </Stack>
	    <Title order={1}>Order Items:</Title>
	    {
	    Array.from({length: 3}, (_,i) => <Product key={i}
						      title={"Nvidia Gforce Rtx 3070 TI"}
						      img={"https://www.nvidia.com/content/dam/en-zz/Solutions/geforce/ampere/rtx-3070/geforce-rtx-3070-shop-600-p@2x.png"}
						      id={i}
						      quantity={1}
						      total={599.99}
						      unit_price={599.99}
						      img_url={"https://www.broadberry.co.uk/img/gpu-compare/titanrtx.png"}
					     />)
	    }
	    <Title>Payments</Title>
	  </Stack>
	</Flex>
	<Sidebar />
      </Flex>
    </MantineProvider>
  )
}

export default Order;

const rootElement = document.getElementById('order')
const root = createRoot(rootElement);

root.render(<Order {...Object.assign({}, rootElement.dataset)} />);


