import React from 'react';
import { createRoot } from 'react-dom/client';
import Order from './Order'
import Sidebar from '../components/Sidebar'
import { MantineProvider, Flex, Stack, Title } from '@mantine/core';
import { theme } from '../mantine';
import Profile from './Profile'
import Contact from './Contact'
import Review from './Rate'
import Related from '../components/Related'

function Dashboard(props) {
	const customer = JSON.parse(document.getElementById('dashboard').dataset.customer);
	const invoices = JSON.parse(document.getElementById('dashboard').dataset.invoices);
	return (
		<MantineProvider theme={theme}>
			<Flex className="max-w-screen justify-between m-32 relative">
				<Flex className="items-center justify-center w-full">
					<Stack className="gap-20 flex-wrap justify-center mx-5">

						<Title className="text-main-accent underline">Profile</Title>
						<Profile
							name={customer.name}
							email={customer.email}
							address={customer.address}
							phone={customer.phone_number}
							orders={invoices.length}
							spent={invoices.reduce((total, invoice) => total + parseFloat(invoice.invoice_amount || 0), 0)}
							points={Math.floor(invoices.reduce((total, invoice) => total + parseFloat(invoice.invoice_amount || 0), 0) / 10)}
						/>

						<Title className="text-main-accent underline" mt="40">Recent Orders</Title>
						<Stack gap="50">
							{console.log(invoices)}
							{invoices.length > 0 ? (
								invoices.map((invoice) => (
									<Order
										key={invoice.invoice_id}
										name={`Invoice #${invoice.invoice_id}`}
										id={invoice.invoice_id}
										order_date={invoice.created_at}
										total={invoice.invoice_amount}
										products={invoice.invoiceOrders.map((order) => ({
											name: order.product.name,
											order_date: invoice.created_at,
											delivery_date: '2025-10-15', // Adjust to actual delivery date if available
											quantity: order.quantity,
											unit_price: order.product_cost,
											img_url: order.product.primary_img, // Now available
										}))}
									/>
								))
							) : (
								<p>No orders available.</p>
							)}
						</Stack>
						<Stack className="py-10">
							<Title className="text-center !text-5xl" mb="10" order={1}>Reviews</Title>
							<Review img_url="https://www.broadberry.co.uk/img/gpu-compare/titanrtx.png" name="Nvidia Gforce Rtx 3070 TI" />
						</Stack>
						<Stack>
							<Title className="text-center !text-5xl" mb="10" order={1}>Related Products</Title>
							<Flex gap="20">
								{
									Array.from({ length: 3 }, (_, i) => <Related key={i} name="yes" price="200" id={i + 1}
										description="Condimentum mattis pellentesque id nibh tortor, id aliquet lectus proin nibh nisl"
										img_url="https://www.broadberry.co.uk/img/gpu-compare/titanrtx.png" />)
								}
							</Flex>
						</Stack>
						<Contact phone_number="068334" />
					</Stack>
				</Flex>
				<Sidebar />
			</Flex>
		</MantineProvider>
	)
}

export default Dashboard;

const rootElement = document.getElementById('dashboard')
const root = createRoot(rootElement);

root.render(<Dashboard {...Object.assign({}, rootElement.dataset)} />);


