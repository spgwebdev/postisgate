<?php

namespace SeniorProgramming\PostisGate\Operations;

use SeniorProgramming\PostisGate\Core\Endpoint;
use SeniorProgramming\PostisGate\Exceptions\PostisGateInvalidParamException;

class CreateShipment extends Endpoint
{
    public $type = 'POST';
    /**
     *
     * @return string
     */
    protected function getCallMethod()
    {
        return '/api/v1/clients/shipments';
    }

    /**
     *
     * @return string
     */
    public function fetchResults()
    {
        return 'parse';
    }

    /**
     *
     * @param array $params
     * @return boolean
     * @throws PostisGateInvalidParamException
     */
    public function rules()
    {
        return [
            'additionalServices.bankRepayment' => 'nullable|numeric',
            'additionalServices.cashOnDelivery' => 'nullable|numeric',
            'additionalServices.cashOnDeliveryReference' => 'nullable|string',
            'additionalServices.insurance' => 'nullable|boolean',
            'additionalServices.openPackage' => 'nullable|boolean',
            'additionalServices.openPackage' => 'nullable|boolean',
            'additionalServices.saturdayDelivery' => 'nullable|boolean',

            'barCode' => 'nullable|string',
            'brutWeight' => 'nullable|numeric',
            'clientId' => 'required|string',
            'clientOrderDate' => 'required|date_format:Y-m-d H:i:s',
            'clientOrderId' => 'required|string',
            'clientOrderType' => 'nullable|string',
            'courierId' => 'nullable|string',
            'declaredValue' => 'nullable|numeric',
            'deliveryOrderDateFrom' => 'nullable|date_format:Y-m-d H:i:s',
            'deliveryOrderDateTill' => 'nullable|date_format:Y-m-d H:i:s',
            'height' => 'nullable|numeric',
            'length' => 'nullable|numeric',
            'netWeight' => 'nullable|numeric',
            'noEnvelops' => 'nullable|numeric',
            'noPalettes' => 'nullable|numeric',
            'noParcels' => 'nullable|numeric',
            'oversizedPackage' => 'nullable|boolean',
            'packingList' => 'nullable|string',
            'packingPersonalData' => 'nullable|string',
            'paymentType' => 'required|in:CASH,CREDIT_CARD,PAYMENT_ORDER',
            'pickupDate' => 'nullable|date_format:Y-m-d H:i:s',
            'podType' => 'nullable|in:CMR,AVIZ,DAMAGE,OTHER',
            'productCategory' => 'required|string',

            'recipientLocation.addressText' => 'required|string',
            'recipientLocation.buildingNumber' => 'nullable|string',
            'recipientLocation.contactPerson' => 'required|string',
            'recipientLocation.country' => 'required|string',
            'recipientLocation.county' => 'required|string',
            'recipientLocation.email' => 'nullable|string',
            'recipientLocation.fax' => 'nullable|string',
            'recipientLocation.locality' => 'required|string',
            'recipientLocation.locationId' => 'required|string',
            'recipientLocation.name' => 'required|string',
            'recipientLocation.phoneNumber' => 'required|string',
            'recipientLocation.postalCode' => 'required|string',
            'recipientLocation.streetName' => 'nullable|string',

            'recipientReference' => 'nullable|string',
            'reference01' => 'nullable|string',
            'reference02' => 'nullable|string',
            'sendType' => 'required|in:FORWARD,BACK,REPAIR,FORWARD_AND_BACK',

            'senderLocation.addressText' => 'required|string',
            'senderLocation.buildingNumber' => 'required|string',
            'senderLocation.contactPerson' => 'required|string',
            'senderLocation.country' => 'required|string',
            'senderLocation.county' => 'required|string',
            'senderLocation.email' => 'nullable|string',
            'senderLocation.fax' => 'nullable|string',
            'senderLocation.locality' => 'nullable|string',
            'senderLocation.locationId' => 'required|string',
            'senderLocation.name' => 'required|string',
            'senderLocation.phoneNumber' => 'required|string',
            'senderLocation.postalCode' => 'required|string',
            'senderLocation.streetName' => 'nullable|string',

            'senderLocationId' => 'nullable|string',
            'senderReference' => 'nullable|string',
            'shipmentId' => 'nullable|string',

            'shipmentParcels.*.barCode' => 'nullable|string',
            'shipmentParcels.*.itemCategory' => 'nullable|string',
            'shipmentParcels.*.itemCode' => 'required|string',
            'shipmentParcels.*.itemDescription1' => 'required|string',
            'shipmentParcels.*.itemDescription2' => 'nullable|string',
            'shipmentParcels.*.itemEANCode' => 'nullable|string',
            'shipmentParcels.*.itemSubCategory1' => 'nullable|string',
            'shipmentParcels.*.itemSubCategory2' => 'nullable|string',
            'shipmentParcels.*.itemSubCategory3' => 'nullable|string',
            'shipmentParcels.*.itemUOMCode' => 'required|string',
            'shipmentParcels.*.parcelBrutWeight' => 'required_without:shipmentParcels.*.parcelNetWeight|numeric',
            'shipmentParcels.*.parcelContent' => 'nullable|string',
            'shipmentParcels.*.parcelDeclaredValue' => 'required|numeric',
            'shipmentParcels.*.parcelHeight' => 'nullable|numeric',
            'shipmentParcels.*.parcelLength' => 'nullable|numeric',
            'shipmentParcels.*.parcelNetWeight' => 'required_without:shipmentParcels.*.parcelBrutWeight|numeric',
            'shipmentParcels.*.parcelReferenceId' => 'required|string',
            'shipmentParcels.*.parcelType' => 'required|in:ENVELOPE,PACKAGE,PALETTE',
            'shipmentParcels.*.parcelVolumetricWeight' => 'nullable|numeric',
            'shipmentParcels.*.parcelWidth' => 'nullable|numeric',

            'shipmentPayer' => 'required|in:SENDER,RECEIVER',
            'shipmentReference' => 'required|string',
            'shippingInstruction' => 'nullable|string',
            'sourceChannel' => 'required|in:ONLINE,RETAIL,MANUAL',
            'unloadingSeq' => 'nullable|numeric',
            'volumetricWeight' => 'nullable|numeric',
            'width' => 'nullable|numeric',
        ];
    }

    public function message()
    {
        return [];
    }
}

