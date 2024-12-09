/********************************
Developer: Mihail Vacarciuc , Robert Oros
University ID: 230238428, 230237144
********************************/
import React from 'react'
import { Stack, Flex, Button,Title, Text, NumberInput } from '@mantine/core'
import {Stars} from '../components/Stars'
import {InStock} from '../components/InStock'

export default function Info({productName,rating, inStock,description,price, id}){

  return (
    <Stack className="max-w-[600px] justify-around h-full">
      <Flex className="items-center gap-2">
      <Title>{productName}</Title>
      <InStock inStock={inStock} />
      </Flex>
      <Stars rating={rating} />
      <Description description={description} />
      <Submit id={id} price={price} />
    </Stack>
  )
}

function Description({description}){
  const [expanded, setExpanded] = React.useState(false)
  return (
    <Text onClick={() => setExpanded(!expanded) } lineClamp={expanded ? 0 : 4}>{description}</Text>
  )
}
function Submit({ id, price }) {
  console.log(id)
  const [qty, setQty] = React.useState(1);

  return (
    <form
      className="flex flex-col gap-2"
      method="POST"
      action={`/basket/add/${id}`} // Direct Laravel route
    >
      {/* CSRF Token for Laravel */}
      <input
        type="hidden"
        name="_token"
        value={document.querySelector('meta[name="csrf-token"]').getAttribute('content')}
      />

      {/* Hidden Input for Quantity */}
      <input type="hidden" name="quantity" value={qty} />

      <Title order={1} my="20">
        {Intl.NumberFormat('en-GB', {
          maximumSignificantDigits: 2,
          currency: 'GBP',
          style: 'currency',
        }).format(price * qty)}
      </Title>

      <Flex align="center" gap="10">
        <Title className="text-main-green" order={3}>
          Free Delivery
        </Title>
        <svg
          xmlns="http://www.w3.org/2000/svg"
          width="40"
          height="40"
          viewBox="0 0 24 24"
          fill="none"
          stroke="currentColor"
          strokeWidth="2"
          strokeLinecap="round"
          strokeLinejoin="round"
          className="icon icon-tabler icons-tabler-outline icon-tabler-truck"
        >
          <path stroke="none" d="M0 0h24V24H0z" fill="none" />
          <path d="M7 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
          <path d="M17 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
          <path d="M5 17h-2v-11a1 1 0 0 1 1 -1h9v12m-4 0h6m4 0h2v-6h-8m0 -5h5l3 5" />
        </svg>
      </Flex>

      <NumberInput
        value={qty}
        onChange={setQty}
        className="w-20 rounded-md"
        min={1}
        max={100}
        label="Quantity"
        leftSection={
          <button
            onClick={(e) => {
              e.preventDefault();
              qty > 1 && setQty(qty - 1);
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
        }
        rightSection={
          <button
            onClick={(e) => {
              e.preventDefault();
              qty < 100 && setQty(qty + 1);
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

      <Button type="submit" className="!rounded-md !w-96 !h-14">
        Add to cart
      </Button>
    </form>
  );
}