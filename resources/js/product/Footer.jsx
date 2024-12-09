/********************************
Developer: Mihail Vacarciuc 
University ID: 230238428
********************************/
import React from 'react';
import { Title, Text, Stack } from '@mantine/core';

export default function Footer({ description }) {
  return (
    <Stack className="w-full" style={{ maxWidth: '800px', margin: '0 auto' }}>
      <Title>Description</Title>
      <Text>{description}</Text>
    </Stack>
  );
}
