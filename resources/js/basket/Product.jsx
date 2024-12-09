/********************************
Developer: Mihail Vacarciuc , Robert Oros
University ID: 230238428, 230237144
********************************/
import React from 'react';
import { Stack, Flex, NumberInput, Title, Text } from '@mantine/core';

export default function Product({
  id,
  name,
  onChangeProduct,
  price,
  description,
  category,
  img_url,
  quantity,
  onQuantityChange,
}) {
  const [qty, setQty] = React.useState(Math.floor(quantity)); // Ensure quantity is an integer
  const [loading, setLoading] = React.useState(false);

  const handleUpdateQuantity = (newQuantity) => {
    const integerQuantity = Math.floor(newQuantity); // Enforce integer
    setLoading(true);

    fetch(`/basket/${id}`, {
      method: 'PUT',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-TOKEN': document
          .querySelector('meta[name="csrf-token"]')
          .getAttribute('content'),
      },
      body: JSON.stringify({ quantity: integerQuantity }),
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error('Failed to update quantity');
        }
        return response.json();
      })
      .then(() => {
        setQty(integerQuantity); // Update local state
        setLoading(false);
	onChangeProduct();

        // Notify parent about the quantity change
        onQuantityChange(id, integerQuantity);
      })
      .catch((error) => {
        console.error('Error updating quantity:', error);
        setLoading(false);
      });
  };

  const handleDelete = () => {
    handleUpdateQuantity(0); // Setting quantity to 0 removes the product
  };

  return (
    <Stack className="px-4 py-4 max-w-[700px] rounded-md border-b-2 border-black">
      <Title order={4}>{name}</Title>
      <Flex gap="40">
        <Stack className="flex-1">
          <img alt={name} src={img_url} className="w-40" />
        </Stack>
        <Stack className="flex-[2]">
          <Text>{description}</Text>
          <Title order={6}>{category}</Title>
          <NumberInput
            value={qty}
            onChange={(value) => {
              if (value !== null && value >= 1 && value <= 100) {
                handleUpdateQuantity(value);
              }
            }}
            disabled={loading}
            className="w-20 rounded-md"
            min={1}
            max={100}
            label="Quantity"
            leftSection={
              qty === 1 ? (
                <button
                  onClick={(e) => {
                    e.preventDefault();
                    handleDelete();
                  }}
                  className="text-red-500"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    strokeWidth="2"
                    strokeLinecap="round"
                    strokeLinejoin="round"
                    className="icon icon-tabler icons-tabler-outline icon-tabler-trash"
                  >
                    <path stroke="none" d="M0 0h24V24H0z" fill="none" />
                    <path d="M4 7l16 0" />
                    <path d="M10 11l0 6" />
                    <path d="M14 11l0 6" />
                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                  </svg>
                </button>
              ) : (
                <button
                  onClick={(e) => {
                    e.preventDefault();
                    if (qty > 1) handleUpdateQuantity(qty - 1);
                  }}
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    strokeWidth="2"
                    strokeLinecap="round"
                    strokeLinejoin="round"
                    className="icon icon-tabler icons-tabler-outline icon-tabler-circle-minus"
                  >
                    <path stroke="none" d="M0 0h24V24H0z" fill="none" />
                    <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                    <path d="M9 12l6 0" />
                  </svg>
                </button>
              )
            }
            rightSection={
              <button
                onClick={(e) => {
                  e.preventDefault();
                  if (qty < 100) handleUpdateQuantity(qty + 1);
                }}
                className="mr-2"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="24"
                  height="24"
                  viewBox="0 0 24 24"
                  fill="none"
                  stroke="currentColor"
                  strokeWidth="2"
                  strokeLinecap="round"
                  strokeLinejoin="round"
                  className="icon icon-tabler icons-tabler-outline icon-tabler-circle-plus"
                >
                  <path stroke="none" d="M0 0h24V24H0z" fill="none" />
                  <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                  <path d="M9 12h6" />
                  <path d="M12 9v6" />
                </svg>
              </button>
            }
          />
        </Stack>
        <Title>£{(price * qty).toFixed(2)}</Title>
      </Flex>
    </Stack>
  );
}
