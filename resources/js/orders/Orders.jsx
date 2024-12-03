import React from 'react';
import { createRoot } from 'react-dom/client';
import Order from '../dashboard/Order'
import Sidebar from '../components/Sidebar'
import { MantineProvider, Flex, Stack } from '@mantine/core';
import { theme } from '../mantine';

function Orders(props){
  console.log(props)
  return (
    <MantineProvider theme={theme}>
      <Flex className="max-w-screen justify-between m-24 relative">
	<Flex className="items-center justify-center w-full">
	  <Stack className="gap-20 flex-wrap justify-center mx-5">
	    {
	    Array.from({length: 100}, (_,i) => <Order key={i}
							name={"Nvidia Gforce Rtx 3070 TI"}
							img={"https://www.nvidia.com/content/dam/en-zz/Solutions/geforce/ampere/rtx-3070/geforce-rtx-3070-shop-600-p@2x.png"}
						      id={i}
							order_date={"2021-10-10"}
						      total={599.99}
						      products={[
						      {
							"name": "Nvidia Gforce Rtx 3070 TI",
							"order_date": "2021-10-10",
							"delivery_date": "2021-10-15",
							"quantity": 1,
							"unit_price": 599.99,
							"img_url": "https://www.broadberry.co.uk/img/gpu-compare/titanrtx.png"
						      },
						      {
							"name": "Nvidia Gforce Rtx 3070 TI",
							"order_date": "2021-10-10",
							"delivery_date": "2021-10-15",
							"quantity": 1,
							"unit_price": 599.99,
							"img_url": "https://www.broadberry.co.uk/img/gpu-compare/titanrtx.png"
						      },
						      {
							"name": "Nvidia Gforce Rtx 3070 TI",
							"order_date": "2021-10-10",
							"delivery_date": "2021-10-15",
							"quantity": 1,
							"unit_price": 599.99,
							"img_url": "https://www.broadberry.co.uk/img/gpu-compare/titanrtx.png"
						      },
						      {
							"name": "Nvidia Gforce Rtx 3070 TI",
							"order_date": "2021-10-10",
							"delivery_date": "2021-10-15",
							"quantity": 1,
							"unit_price": 599.99,
							"img_url": "https://www.broadberry.co.uk/img/gpu-compare/titanrtx.png"
						      },
						      {
							"name": "Nvidia Gforce Rtx 3070 TI",
							"order_date": "2021-10-10",
							"delivery_date": "2021-10-15",
							"quantity": 1,
							"unit_price": 599.99,
							"img_url": "https://www.broadberry.co.uk/img/gpu-compare/titanrtx.png"
						      }

						      ]}
						      price={599.99}
						      inStock={false}
							wishList={false}
							id={i}
					       />)
	    }
	  </Stack>
	</Flex>
	<Sidebar />
      </Flex>
    </MantineProvider>
  )
}

export default Orders;

const rootElement = document.getElementById('orders')
const root = createRoot(rootElement);

root.render(<Orders {...Object.assign({}, rootElement.dataset)} />);


