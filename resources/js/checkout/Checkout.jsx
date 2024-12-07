import React from 'react';
import { createRoot } from 'react-dom/client';
import { MantineProvider, Flex, Stack, Title } from '@mantine/core';
import { theme } from '../mantine';
import Sidebar from './Sidebar';
import Form from './Form';
import {fetchBasket} from '../basket/fetchBasket';

function Checkout(props){
  const [basketItems,setBasketItems] = React.useState([]);
  const [total,setTotal] = React.useState(0);

  React.useEffect(() => {
    fetchBasket().then((basket) => {
      console.log(basket);
      setTotal(basket.total);
      setBasketItems(basket.cartItems);
    });
  }, []);
  
  return (
    <MantineProvider theme={theme}>
      <Flex className="max-w-screen justify-center relative mt-28" gap="50">
	<Form />
	<Sidebar vat={total*0.2} total={total} basketItems={basketItems} />
      </Flex>
    </MantineProvider>
  )
}

export default Checkout;

const rootElement = document.getElementById('checkout')
const root = createRoot(rootElement);

root.render(<Checkout {...Object.assign({}, rootElement.dataset)} />);


