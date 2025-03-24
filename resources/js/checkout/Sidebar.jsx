/********************************
Developer: Mihail Vacarciuc , Robert Oros
University ID: 230238428, 230237144
********************************/
import React from 'react'
import { Stack, Flex, Button, Title, Tooltip, NumberFormatter } from '@mantine/core'
import { useState } from 'react';

export default function Sidebar({ vat, total, basketItems,delivery_cost}) {
  return (
    <Stack>
      <Title order={1}>Your Basket</Title>
      <Flex align="baseline" gap="15">
        <Title order={6}>Delivery cost: {Intl.NumberFormat('en-GB', { decimalScale: 2, currency: 'GBP', style: "currency" }).format(delivery_cost)}</Title>
        <Title order={6}>VAT: {Intl.NumberFormat('en-GB', { decimalScale: 2, currency: 'GBP', style: "currency" }).format(vat)} </Title>
        <Tooltip label="20% VAT is applied to all products you have selected">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" className="icon icon-tabler icons-tabler-outline icon-tabler-info-circle"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M12 9h.01" /><path d="M11 12h1v4h1" /></svg>
        </Tooltip>
      </Flex>
      <Title order={4}>Total:
        <NumberFormatter value={total} prefix="$" decimalScale={2} />
      </Title>
      <Stack className="my-2 py-4 border-t-2 border-black">
        {
          basketItems.map((i, index) => <Product key={i} name={i.name} img_url={i.img_url} qty={i.quantity} price={i.price} />)
        }
      </Stack>
    </Stack>
  )
}

const Product = ({ name, img_url, qty, price }) => {
  return (
    <Flex gap="20">
      <img alt="" src={img_url.replace("max","gross")} className=" h-24" />
      <Stack>
        <h1 className="font-bold">{name}</h1>
        <h3>Quantity: {qty}</h3>
        <h2>Unit Price: {Intl.NumberFormat('en-GB', { decimalScale: 2, currency: 'GBP', style: "currency" }).format(price)}</h2>
        <h2>Total Price: {Intl.NumberFormat('en-gb', { decimalScale: 2, currency: 'gbp', style: "currency" }).format(price * qty)}</h2>
      </Stack>
    </Flex>
  )
}
