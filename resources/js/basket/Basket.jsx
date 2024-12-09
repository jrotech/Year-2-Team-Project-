/********************************
Developer: Mihail Vacarciuc , Robert Oros
University ID: 230238428, 230237144
********************************/

import React, { useEffect, useState } from 'react';
import { createRoot } from 'react-dom/client';
import { theme } from '../mantine';
import { MantineProvider, Flex, Stack, Title, Button, Center } from '@mantine/core';
import Product from './Product';
import Sidebar from './Sidebar'; 
import { fetchBasket as getBasket } from './fetchBasket';

function Basket() {
  const [basketItems, setBasketItems] = useState([]);
  const [total, setTotal] = useState(0);

  const fetchBasket = async () => {
    const basket = await getBasket();
    setBasketItems(basket.cartItems);
    setTotal(basket.total)
  }

  const clearBasket = async () => {
      try{
	const req = await fetch('/api/basket', {
	  headers: {
	    'Accept': 'application/json', 
	  'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
	},
	  method: "DELETE",
	})
	const res = await req.json();
	fetchBasket();
      }catch(e){
	console.log(e)
      }
    }


  useEffect(() => {
    fetchBasket()
  }, []);

  const handleQuantityChange = (id, newQuantity) => {
    // Update the quantity in the basket
    setBasketItems((prevItems) =>
      prevItems.map((item) =>
        item.id === id ? { ...item, quantity: newQuantity } : item
      )
    );

    // Recalculate the total
    const newTotal = basketItems.reduce((acc, item) => {
      if (item.id === id) {
        return acc + item.price * newQuantity;
      }
      return acc + item.price * item.quantity;
    }, 0);
    setTotal(newTotal);
  };


  return (
    <MantineProvider theme={theme}>
      <Stack>
      <Flex className="max-w-screen justify-center relative mt-28" gap="30">
        <Stack>
	  {basketItems.length === 0 && <Title>Your basket is empty</Title>}
          {basketItems.map((item) => {

	    if(item.price == 0) return null
	    return (
            <Product
	      onChangeProduct={fetchBasket}
              key={item.id}
              id={item.id}
              name={item.name}
              price={item.price}
              description={item.description}
              category={item.category}
              img_url={item.img_url}
              quantity={item.quantity}
              onQuantityChange={handleQuantityChange} // Pass the callback
            />
	    )
          })}
          <Title>Subtotal: £{total.toFixed(2)}</Title>
        </Stack>
        <Sidebar total={total*1.3} vat={total*0.2} delivery_cost={total*0.1} subtotal={total} />
      </Flex>
      <Center>
	<Button onClick={clearBasket} color="red">Clear Basket</Button>
      </Center>
      </Stack>
    </MantineProvider>
  );
}

export default Basket;

const rootElement = document.getElementById('basket');
const root = createRoot(rootElement);

root.render(<Basket />);
