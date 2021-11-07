<?php

namespace App\Application;

use App\Application\Interfaces\IEnrollRepository;
use App\Application\Interfaces\IFindCourseById;
use App\Application\Interfaces\IFindIfStudentIsEnrolled;
use App\Application\Interfaces\IFindStudentWithCoursesById;
use App\Application\Interfaces\IStoreOrder;
use App\Application\Interfaces\ITotalStudentCredits;
use App\Course;
use App\Exceptions\EnrollmentErrorException;
use App\Http\Interfaces\IAdressRepository;
use App\Http\Interfaces\ICustomerRepository;
use App\Http\Interfaces\IEnroll;
use App\Http\Interfaces\IOrderRepository;
use App\Http\Interfaces\ISupplierRepository;
use App\Http\Requests\EnrollStudentRequest;
use App\Http\Requests\StoreOrderRequest;
use App\Models\Adress;
use App\Models\Order;
use App\Student;

class StoreOrder implements IStoreOrder
{
    private $orderRepository;
    private $adressRepository;
    private $customerRepository;
    private $supplierRepository;

    public function __construct(IOrderRepository $orderRepository, IAdressRepository $adressRepository,
                                ICustomerRepository $customerRepository, ISupplierRepository $supplierRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->adressRepository = $adressRepository;
        $this->customerRepository = $customerRepository;
        $this->supplierRepository = $supplierRepository;
    }

    public function execute(StoreOrderRequest $request)
    {
        $order = $this->orderRepository->factory($request->all());
        // pesquisa pelo endereco origem
        $adressOrigin = $this->adressRepository->findByStreetAndNumber($request->origin_adress['street'],$request->origin_adress['number']);
        if(!$adressOrigin)
        {
            $addr = $request->origin_adress;
            $adressOrigin = $this->adressRepository->factory($addr);
        }
        $this->adressRepository->persist($adressOrigin);
  
        // pesquisa pelo enderco de entrega
        $adressDestiny = $this->adressRepository->findByStreetAndNumber($request->destination_adress['street'],$request->destination_adress['number']);
        if(!$adressDestiny)
        {
            $addr = $request->destination_adress;
            $adressDestiny = $this->adressRepository->factory($addr);
        }
        $this->adressRepository->persist($adressDestiny);

        $customer = $this->customerRepository->findByEmail($request->customer['email']);
        if(!$customer){
            $cust = $request->customer;
            $customer = $this->customerRepository->factory($cust);
            $this->customerRepository->persist($customer);
        }

        $supplier = $this->supplierRepository->findByEmail($request->supplier['email']);
        if(!$supplier){
            $supl = $request->supplier;
            $supplier = $this->supplierRepository->factory($supl);
            $this->supplierRepository->persist($supplier);
        }

        $order->customer_id = $customer->id;
        $order->origin_adress_id = $adressOrigin->id;
        $order->destination_adress_id = $adressDestiny->id;
        $order->supplier_id = $supplier->id;

        $this->orderRepository->persist($order);
        return $order; // remover
    }
}