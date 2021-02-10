<?php

namespace App\Entity\Master;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="sym_api_admin_user_master.collaborated_projectinvitetracking")
 * @ORM\Entity(repositoryClass="App\Repository\Master\CollaboratedProjectInvitetrackingRepository")
 */
class CollaboratedProjectInvitetracking
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="createDate", type="datetime", nullable=true)
     */
    private $createDate;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="modifiedDate", type="datetime", nullable=true)
     */
    private $modifiedDate;

    /**
     * @ORM\Column(type="integer", name="interestId", length=20, nullable=true)
     */
    private $interestId;

    /**
     * @ORM\Column(type="integer", name="inviteFrom", length=20, nullable=true)
     */
    private $inviteFrom;

    /**
     * @ORM\Column(type="integer", name="inviteTo", length=20, nullable=true)
     */
    private $inviteTo;

    /**
     * @ORM\Column(type="string", name="invitationStatus", length=75, nullable=true)
     */
    private $invitationStatus;

    /**
     * @ORM\Column(type="integer", name="isRead", length=20, nullable=true)
     */
    private $isRead;

    /**
     * @ORM\Column(type="integer", name="isRemoved", length=20, nullable=true)
     */
    private $isRemoved;

    /**
     * @ORM\Column(type="string", name="messageTitle", length=200, nullable=true)
     */
    private $messageTitle;

    /**
     * @ORM\Column(type="string", name="messageContent", length=1000, nullable=true)
     */
    private $messageContent;

    /**
     * @ORM\Column(type="string", name="emailContent", length=1000, nullable=true)
     */
    private $emailContent;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreateDate(): ?\DateTimeInterface
    {
        return $this->createDate;
    }

    public function setCreateDate(?\DateTimeInterface $createDate): self
    {
        $this->createDate = $createDate;

        return $this;
    }

    public function getModifiedDate(): ?\DateTimeInterface
    {
        return $this->modifiedDate;
    }

    public function setModifiedDate(?\DateTimeInterface $modifiedDate): self
    {
        $this->modifiedDate = $modifiedDate;

        return $this;
    }

    public function getProjectId(): ?int
    {
        return $this->projectId;
    }

    public function setProjectId(?int $projectId): self
    {
        $this->projectId = $projectId;

        return $this;
    }

    public function getInviteFrom(): ?int
    {
        return $this->inviteFrom;
    }

    public function setInviteFrom(?int $inviteFrom): self
    {
        $this->inviteFrom = $inviteFrom;

        return $this;
    }

    public function getInviteTo(): ?int
    {
        return $this->inviteTo;
    }

    public function setInviteTo(?int $inviteTo): self
    {
        $this->inviteTo = $inviteTo;

        return $this;
    }

    public function getInvitationStatus(): ?string
    {
        return $this->invitationStatus;
    }

    public function setInvitationStatus(?string $invitationStatus): self
    {
        $this->invitationStatus = $invitationStatus;

        return $this;
    }

    public function getIsRead(): ?int
    {
        return $this->isRead;
    }

    public function setIsRead(?int $isRead): self
    {
        $this->isRead = $isRead;

        return $this;
    }

    public function getIsRemoved(): ?int
    {
        return $this->isRemoved;
    }

    public function setIsRemoved(?int $isRemoved): self
    {
        $this->isRemoved = $isRemoved;

        return $this;
    }

    public function getMessageTitle(): ?string
    {
        return $this->messageTitle;
    }

    public function setMessageTitle(?string $messageTitle): self
    {
        $this->messageTitle = $messageTitle;

        return $this;
    }

    public function getMessageContent(): ?string
    {
        return $this->messageContent;
    }

    public function setMessageContent(?string $messageContent): self
    {
        $this->messageContent = $messageContent;

        return $this;
    }

    public function getEmailContent(): ?string
    {
        return $this->emailContent;
    }

    public function setEmailContent(?string $emailContent): self
    {
        $this->emailContent = $emailContent;

        return $this;
    }


}
