<?php

namespace App\Repositories\Interfaces;

interface ContactRepositoryInterface
{
    /**
     * Store a contact form submission
     *
     * @param array $data
     * @return bool
     */
    public function storeContactMessage(array $data): bool;
    
    /**
     * Get all contact form submissions with pagination
     *
     * @param int $perPage
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getAllContactMessages(int $perPage = 10);
    
    /**
     * Get a contact message by ID
     *
     * @param int $id
     * @return mixed
     */
    public function getContactMessageById(int $id);
    
    /**
     * Mark a contact message as read
     *
     * @param int $id
     * @return bool
     */
    public function markAsRead(int $id): bool;
    
    /**
     * Delete a contact message
     *
     * @param int $id
     * @return bool
     */
    public function deleteContactMessage(int $id): bool;
}