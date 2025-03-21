/********************************
Developer: Mihail Vacarciuc , Robert Oros
University ID: 230238428, 230237144
********************************/
import React from 'react'
import { Stack, Title, Button } from '@mantine/core'
import { Stars } from '../components/Stars'


export default function Review({img_url, name, product_id}) {
  const handleRedirect = () => {
    window.location.href = `/shop/product/${product_id}`;
  };
  return (
    <Stack className="justify-center w-full my-2 pb-10 border-2 border-main-accent rounded-md py-2" align="center" gap="20">
      <Title order={1} my="50">{name}</Title>
      <img alt="" src={img_url} className="w-96" />
      <Stars rating={2} />
      <Button radius="xl" size="lg" onClick={handleRedirect}>Read More</Button>
    </Stack>
  )
}
