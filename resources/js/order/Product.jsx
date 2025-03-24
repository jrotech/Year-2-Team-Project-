/********************************
Developer: Mihail Vacarciuc , Robert Oros
University ID: 230238428, 230237144
********************************/
import React from 'react';
import {
  Card,
  Flex,
  Stack,
  Title,
  Image,
  Text
} from "@mantine/core";
import { NumberFormatter } from "@mantine/core"; // or wherever NumberFormatter is from
import { InStock } from "../components/InStock";

export default function Product(props) {
  return (
    <Card withBorder radius="md" shadow="sm" p="lg">
      {/* Top-level layout: image on the left, text on the right */}
      <Flex gap="md" align="center" className="flex-col md:flex-row">
        {/* Product Image */}
        <Image
          src={props.img.replace('max', 'gross')}
          alt={props.title}
          width={80}
          height={80}
          fit="contain"
          radius="sm"
        />

        {/* Product details */}
        <Stack spacing="xs" style={{ flex: 1 }}>
          {/* Product title */}
          <Title order={4}>{props.title}</Title>

          {/* Pricing details in a horizontal row */}
          <Flex justify="space-between">
            <Stack spacing={2}>
              <Text size="sm" weight={500}>Unit Price</Text>
              <Text size="md" weight={600} c="blue">
                <NumberFormatter prefix="£" value={props.unit_price} thousandSeparator />
              </Text>
            </Stack>

            <Stack spacing={2}>
              <Text size="sm" weight={500}>Quantity</Text>
              <Text size="md" weight={600}>
                {props.quantity}
              </Text>
            </Stack>

            <Stack spacing={2}>
              <Text size="sm" weight={500}>Total</Text>
              <Text size="md" weight={600} c="green">
                <NumberFormatter
                  prefix="£"
                  value={props.quantity * props.unit_price}
                  thousandSeparator
                />
              </Text>
            </Stack>
          </Flex>

          {/* Any extra children you pass in */}
          {props.children}
        </Stack>
      </Flex>
    </Card>
  );
}
