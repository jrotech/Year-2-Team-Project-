import React, { useEffect, useState } from 'react';
import { createRoot } from 'react-dom/client';
import { MantineProvider, Flex, Stack, Title } from '@mantine/core';
import Product from './Product'; // Ensure correct path
import Sidebar from './Sidebar'; // Optional

function Basket() {
  const [basketItems, setBasketItems] = useState([]);
  const [total, setTotal] = useState(0);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    // Fetch basket contents from the API
    fetch('/api/basket', {
      headers: {
        'Accept': 'application/json',
      },
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error('Failed to fetch basket');
        }
        return response.json();
      })
      .then((data) => {
        setBasketItems(data.cartItems);
        setTotal(data.total);
        setLoading(false);
      })
      .catch((error) => {
        console.error('Error fetching basket:', error);
        setLoading(false);
      });
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

  if (loading) {
    return <div>Loading...</div>;
  }

  if (basketItems.length === 0) {
    return <Title>Your basket is empty</Title>;
  }

  return (
    <MantineProvider>
      <Flex className="max-w-screen justify-center relative mt-28" gap="30">
        <Stack>
          {basketItems.map((item) => (
            <Product
              key={item.id}
              id={item.id}
              name={item.name}
              price={item.price}
              description={item.description}
              category={item.category.join(', ')}
              img_url={item.img_url}
              quantity={item.quantity}
              onQuantityChange={handleQuantityChange} // Pass the callback
            />
          ))}
          <Title>Total: ${total.toFixed(2)}</Title>
        </Stack>
        <Sidebar />
      </Flex>
    </MantineProvider>
  );
}

export default Basket;

const rootElement = document.getElementById('basket');
const root = createRoot(rootElement);

root.render(<Basket />);
