import React from 'react';
import { createRoot } from 'react-dom/client';
import Sidebar from '../components/Sidebar'
import { MantineProvider, Flex, Stack, Title, Text } from '@mantine/core';
import { theme } from '../mantine';
import Product from './Product';

function Order(props) {
	const invoice = JSON.parse(props.invoice)
	console.log(invoice)


	const transformDate = (pdate) => {
		const timestamp = pdate;
		const date = new Date(timestamp);
		const formattedDate = `${date.getDate().toString().padStart(2, '0')}/${(date.getMonth() + 1).toString().padStart(2, '0')
			}/${date.getFullYear()}`;

		return formattedDate;
	}
	return (
		<MantineProvider theme={theme}>
			<Flex className="max-w-screen justify-between m-24 relative">
				<Flex className="items-center justify-center w-full">
					<Stack className="gap-40 flex-wrap justify-center mx-5">

						<Title order={1}>Order Date: {transformDate(invoice.created_at)}</Title>
						<Stack className="bg-white rounded-md p-10" gap="10">
							<Flex gap="50">
								<Stack gap="10">
									<Title order={5}>Order Number:{invoice.invoice_id}</Title>
									<Text order={6}>Order Status: {invoice.status.charAt(0).toUpperCase() + invoice.status.slice(1)}</Text>
									<Text order={3}>Order Total: £{invoice.amount}</Text>
								</Stack>
								<Stack align="center" className="cursor-pointer">
									<Text order={6}>Download Invoice</Text>
									<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-download"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" /><path d="M7 11l5 5l5 -5" /><path d="M12 4l0 12" /></svg>
								</Stack>
								<Stack>
									<Title order={3}>Shipping Address:</Title>
									<p>Address:{invoice.address}</p>
									<p>Postcode: {invoice.postcode}</p>
								</Stack>
							</Flex>
						</Stack>
						<Title order={1}>Order Items:</Title>
						{
							invoice.invoice_orders.map((invoice_order, index) => (
								<Product key={index}
									title={invoice_order.product.name}
									img={invoice_order.product.image}
									id={invoice_order.id}
									quantity={invoice_order.quantity}
									total={invoice_order.quantity * invoice_order.product.price}
									unit_price={invoice_order.product.price}
								/>))
						}
						<Title>Payments</Title>
					</Stack>
				</Flex>
				<Sidebar />
			</Flex>
		</MantineProvider>
	)
}

export default Order;

const rootElement = document.getElementById('order')
const root = createRoot(rootElement);

root.render(<Order {...Object.assign({}, rootElement.dataset)} />);


