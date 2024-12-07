import React, {useState, useEffect } from 'react';
import { Stack, TextInput, Button, Text, Flex,Stepper, Group, NumberInput, Card, Title } from '@mantine/core';
import { useForm } from '@mantine/form';
import confetti from 'canvas-confetti'

export default function Form(){
  const [active, setActive] = useState(0);
  const nextStep = () => setActive((current) => (current < 3 ? current + 1 : current));
  const prevStep = () => setActive((current) => (current > 0 ? current - 1 : current));
  const [personalDetails, setPersonalDetails] = useState({
      first_name: '',
      last_name: '',
      address: '',
      postal_code: '',
      email: '',
      phone_number: '',
  });
  const [cardDetails, setCardDetails] = useState({
    cardNumber: '',
    cardHolderName: '',
    expiryDate: '',
    cvv: '',
  });

  return (
    <Stack>
      <Stepper active={active} onStepClick={setActive}>
        <Stepper.Step label="Personal Details" description="">
          <PersonalDetails next={ (values) =>{setPersonalDetails(values);nextStep()}} initial={personalDetails} />
        </Stepper.Step>
        <Stepper.Step label="Payment" description="Payment Details">
          <CardPaymentForm next={ (values) => {setCardDetails(values);nextStep()} } />
        </Stepper.Step>
        <Stepper.Step label="Finish">
          <Finish/>
        </Stepper.Step>
      </Stepper>

      <Group justify="center" mt="xl">
        { active == 1 && <Button variant="default" onClick={prevStep}>Back</Button>}
      </Group>
    </Stack>
  );
  
}

function PersonalDetails({next, initial}){
  const form = useForm({
    initialValues: initial,
    validate: {
      first_name: (value) => value.trim().length > 0 ? null : 'First name is required',
      last_name: (value) => value.trim().length > 0 ? null : 'Last name is required',
      address: (value) => value.trim().length > 0 ? null : 'Address is required',
      postal_code: (value) => value.trim().length > 0 ? null : 'Postal code is required',
      email: (value) => value.trim().length > 0 ? null : 'Email is required',
      phone_number: (value) => value.trim().length > 0 ? null : 'Phone number is required',
    },
  });

  const handleSubmit = ( values ) => {
    console.log(values);
  }

  return (
    <Stack>
      <form onSubmit={form.onSubmit(next)} className="flex gap-y-4 flex-col">
	<Flex gap="10" className="items-stretch justify-stretch">
	  <TextInput {...form.getInputProps("first_name")} label="First Name" required/>
	  <TextInput {...form.getInputProps("last_name")} label="Last Name" required/>
	</Flex>
	<TextInput {...form.getInputProps("address")} label="Address"  required />
	<TextInput {...form.getInputProps("postal_code")} label="Postal Code" required />
	<Flex gap="10">
	  <TextInput {...form.getInputProps("email")} label="Email" required />
	  <TextInput {...form.getInputProps("phone_number")} label="Phone Number"  required />
	</Flex>
	<Button type="submit" mt="10">Next</Button>
      </form>
    </Stack>
  )

}

const CardPaymentForm = ({next,initial}) => {
  const form = useForm({
    mode: 'controlled',
    initialValues: initial,

    validate: {
      cardNumber: (value) =>
        String(value).length === 16 ? null : `Card number must be 16 digits ${value}`,
      cardHolderName: (value) =>
        value.trim() ? null : `Cardholder name is required`,
      expiryDate: (value) =>
        /^[0-1][0-9]\/[0-9]{2}$/.test(value)
          ? null
          : 'Expiry date must be in MM/YY format',
      cvv: (value) =>
        String(value).length === 3 ? null : `CVV must be 3 digits ${value.length}`,
    },
  });

  const handleSubmit = (values) => {
    console.log('Payment details:', values);
    alert('Payment submitted successfully!');
  };

  return (
    <div shadow="sm" padding="lg" radius="md">
      <form onSubmit={form.onSubmit(next)}>
        <TextInput
          label="Cardholder Name"
          placeholder="John Doe"
          {...form.getInputProps('cardHolderName')}
          required
        />

        <NumberInput
	  rightSection={<></>}
          label="Card Number"
          placeholder="1234 5678 9012 3456"
          maxLength={16}
          {...form.getInputProps('cardNumber')}
          required
        />

        <Group grow>
          <TextInput
            label="Expiry Date (MM/YY)"
            placeholder="08/25"
            {...form.getInputProps('expiryDate')}
            required
          />

          <NumberInput
            label="CVV"
            placeholder="123"
            maxLength={3}
            {...form.getInputProps('cvv')}
            required
          />
        </Group>

        <Group position="right" mt="md">
          <Button type="submit">Pay Now</Button>
        </Group>
      </form>
    </div>
  );
};


function Finish(){
    useEffect(() => {
    // Trigger confetti animation
    confetti({
      particleCount: 100,
      spread: 70,
      origin: { y: 0.6, x: 0.42 },
      colors: ['#000000', '#000000', '#999999']
    })
  }, [])

  return (
    <div className="">
        <Card className="w-full max-w-md">
          <Card>
	    <svg  xmlns="http://www.w3.org/2000/svg"  width="30"  height="30"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  strokeWidth="2"  strokeLinecap="round"  strokeLinejoin="round"  className="icon icon-tabler icons-tabler-outline icon-tabler-circle-check"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M9 12l2 2l4 -4" /></svg>
            <Title className="text-2xl font-bold text-center mt-4">Order Successful!</Title>
          </Card>
          <Card>
            <p className="text-center text-muted-foreground">
              Thank you for your purchase. Your order has been received and is being processed.
            </p>
              <h3 className="font-semibold text-primary">Order Details:</h3>
              <p className="text-secondary-foreground">Order #: 123456</p>
              <p className="text-secondary-foreground">Estimated Delivery: 3-5 business days</p>
          </Card>
          <footer className="flex justify-center">
            <Button component="a" href="/shop" className="bg-primary w-full text-primary-foreground font-bold py-2 px-4 rounded-lg">
              Continue Shopping
	      <svg  xmlns="http://www.w3.org/2000/svg"  width="30"  height="30"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  strokeWidth="2"  strokeLinecap="round"  strokeLinejoin="round"  className="icon icon-tabler icons-tabler-outline icon-tabler-arrow-right"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M13 18l6 -6" /><path d="M13 6l6 6" /></svg>
            </Button>
          </footer>
        </Card>
    </div>
  )

}
