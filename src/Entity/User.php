<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use App\Entity\Traits\VichUploadTrait;
// use Symfony\Component\HttpFoundation\File\File;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 * @Vich\Uploadable()
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface, \Serializable
{
    use VichUploadTrait;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=180)
     */
    private $username;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity=Rank::class, mappedBy="idUser")
     */
    private $ranks;

    /**
     * @ORM\ManyToMany(targetEntity=Challenges::class, mappedBy="users")
     */
    private $challenge;

    /**
     * @ORM\OneToMany(targetEntity=Statistical::class, mappedBy="userId")
     */
    private $statisticals;

    /**
     * @ORM\ManyToMany(targetEntity=Group::class, mappedBy="users")
     */
    private $idGroup;

    /**
     * @ORM\OneToMany(targetEntity=UserLikeRemark::class, mappedBy="userId")
     */
    private $userLikeRemarks;

    /**
     * @ORM\OneToMany(targetEntity=UserLikePost::class, mappedBy="userWhoLiked")
     */
    private $userLikePosts;

    /**
     * @ORM\OneToMany(targetEntity=UserLikeChallenge::class, mappedBy="userWhoLikedChallenge")
     */
    private $userLikeChallenges;

    /**
     * @ORM\OneToMany(targetEntity=Message::class, mappedBy="sender")
     */
    private $send_message;

    /**
     * @ORM\OneToMany(targetEntity=Message::class, mappedBy="receiver")
     */
    private $received_message;

    /**
     * @ORM\ManyToOne(targetEntity=Company::class, inversedBy="users")
     */
    private $company;

    /**
     * @ORM\OneToMany(targetEntity=Friends::class, mappedBy="senderUser", orphanRemoval=true)
     */
    private $friendRequestSent;

    /**
     * @ORM\OneToMany(targetEntity=Friends::class, mappedBy="receiverUser", orphanRemoval=true)
     */
    private $friendRequestReceived;

    /**
     * @ORM\ManyToMany(targetEntity=Post::class, mappedBy="userId")
     */
    private $postsId;

    /**
     * @ORM\ManyToMany(targetEntity=Remark::class, mappedBy="userId")
     */
    private $remarks;

    /**
     * @ORM\OneToMany(targetEntity=ChallengesUserRegister::class, mappedBy="userRegister")
     */
    private $challengesUserRegister;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $facebookId;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $googleId;

    /*
     * @ORM\OneToMany(targetEntity=Challenges::class, mappedBy="winner")
     */
    private $challenges;

    /**
     * @ORM\Column(type="boolean")
     */
    private $statut;

    /**
     * @ORM\Column(type="string", length=2)
     */
    private $initials;

    public function __construct()
    {
        $this->ranks = new ArrayCollection();
        $this->challenge = new ArrayCollection();
        $this->statisticals = new ArrayCollection();
        $this->idGroup = new ArrayCollection();
        $this->userLikeRemarks = new ArrayCollection();
        $this->userLikePosts = new ArrayCollection();
        $this->userLikeChallenges = new ArrayCollection();
        $this->send_message = new ArrayCollection();
        $this->received_message = new ArrayCollection();
        $this->friendRequestSent = new ArrayCollection();
        $this->friendRequestReceived = new ArrayCollection();
        $this->postsId = new ArrayCollection();
        $this->remarks = new ArrayCollection();
        $this->challengesUserRegister = new ArrayCollection();
        $this->challenges = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->username;
    }

    public function getUserIdentifier(): string
    {
        return $this->username;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection|Rank[]
     */
    public function getRanks(): Collection
    {
        return $this->ranks;
    }

    public function addRank(Rank $rank): self
    {
        if (!$this->ranks->contains($rank)) {
            $this->ranks[] = $rank;
            $rank->setIdUser($this);
        }

        return $this;
    }

    public function removeRank(Rank $rank): self
    {
        if ($this->ranks->removeElement($rank)) {
            // set the owning side to null (unless already changed)
            if ($rank->getIdUser() === $this) {
                $rank->setIdUser(null);
            }
        }

        return $this;
    }

    public function getIdPost(): ?Post
    {
        return $this->idPost;
    }

    public function setIdPost(?Post $idPost): self
    {
        $this->idPost = $idPost;

        return $this;
    }

    /**
     * @return Collection|Challenges[]
     */
    public function getChallenge(): Collection
    {
        return $this->challenge;
    }

    public function addChallenge(Challenges $challenge): self
    {
        if (!$this->challenge->contains($challenge)) {
            $this->challenge[] = $challenge;
            $challenge->addUser($this);
        }

        return $this;
    }

    public function removeChallenge(Challenges $challenge): self
    {
        if ($this->challenge->removeElement($challenge)) {
            $challenge->removeUser($this);
        }

        return $this;
    }


    /**
     * @return Collection|Statistical[]
     */
    public function getStatisticals(): Collection
    {
        return $this->statisticals;
    }

    public function addStatistical(Statistical $statistical): self
    {
        if (!$this->statisticals->contains($statistical)) {
            $this->statisticals[] = $statistical;
            $statistical->setUserId($this);
        }

        return $this;
    }

    public function removeStatistical(Statistical $statistical): self
    {
        if ($this->statisticals->removeElement($statistical)) {
            // set the owning side to null (unless already changed)
            if ($statistical->getUserId() === $this) {
                $statistical->setUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Group[]
     */
    public function getIdGroup(): Collection
    {
        return $this->idGroup;
    }

    public function addIdGroup(Group $idGroup): self
    {
        if (!$this->idGroup->contains($idGroup)) {
            $this->idGroup[] = $idGroup;
        }

        return $this;
    }

    public function removeIdGroup(Group $idGroup): self
    {
        $this->idGroup->removeElement($idGroup);

        return $this;
    }

    /**
     * @return Collection|UserLikeRemark[]
     */
    public function getUserLikeRemarks(): Collection
    {
        return $this->userLikeRemarks;
    }

    public function addUserLikeRemark(UserLikeRemark $userLikeRemark): self
    {
        if (!$this->userLikeRemarks->contains($userLikeRemark)) {
            $this->userLikeRemarks[] = $userLikeRemark;
            $userLikeRemark->setUserId($this);
        }

        return $this;
    }

    public function removeUserLikeRemark(UserLikeRemark $userLikeRemark): self
    {
        if ($this->userLikeRemarks->removeElement($userLikeRemark)) {
            // set the owning side to null (unless already changed)
            if ($userLikeRemark->getUserId() === $this) {
                $userLikeRemark->setUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|UserLikePost[]
     */
    public function getUserLikePosts(): Collection
    {
        return $this->userLikePosts;
    }

    public function addUserLikePost(UserLikePost $userLikePost): self
    {
        if (!$this->userLikePosts->contains($userLikePost)) {
            $this->userLikePosts[] = $userLikePost;
            $userLikePost->setUserWhoLiked($this);
        }

        return $this;
    }

    public function removeUserLikePost(UserLikePost $userLikePost): self
    {
        if ($this->userLikePosts->removeElement($userLikePost)) {
            // set the owning side to null (unless already changed)
            if ($userLikePost->getUserWhoLiked() === $this) {
                $userLikePost->setUserWhoLiked(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|UserLikeChallenge[]
     */
    public function getUserLikeChallenges(): Collection
    {
        return $this->userLikeChallenges;
    }

    public function addUserLikeChallenges(UserLikeChallenge $userLikeChallenge): self
    {
        if (!$this->userLikeChallenges->contains($userLikeChallenge)) {
            $this->userLikeChallenges[] = $userLikeChallenge;
            $userLikeChallenge->setUserWhoLikedChallenge($this);
        }

        return $this;
    }

    public function removeUserLikeChallenge(UserLikeChallenge $userLikeChallenge): self
    {
        if ($this->userLikeChallenges->removeElement($userLikeChallenge)) {
            // set the owning side to null (unless already changed)
            if ($userLikeChallenge->getUserWhoLikedChallenge() === $this) {
                $userLikeChallenge->setUserWhoLikedChallenge(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getSendMessage(): Collection
    {
        return $this->send_message;
    }

    public function addSendMessage(Message $sendMessage): self
    {
        if (!$this->send_message->contains($sendMessage)) {
            $this->send_message[] = $sendMessage;
            $sendMessage->setSender($this);
        }

        return $this;
    }

    public function removeSendMessage(Message $sendMessage): self
    {
        if ($this->send_message->removeElement($sendMessage)) {
            // set the owning side to null (unless already changed)
            if ($sendMessage->getSender() === $this) {
                $sendMessage->setSender(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getReceivedMessage(): Collection
    {
        return $this->received_message;
    }

    public function addReceivedMessage(Message $receivedMessage): self
    {
        if (!$this->received_message->contains($receivedMessage)) {
            $this->received_message[] = $receivedMessage;
            $receivedMessage->setReceiver($this);
        }

        return $this;
    }

    public function removeReceivedMessage(Message $receivedMessage): self
    {
        if ($this->received_message->removeElement($receivedMessage)) {
            // set the owning side to null (unless already changed)
            if ($receivedMessage->getReceiver() === $this) {
                $receivedMessage->setReceiver(null);
            }
        }

        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): self
    {
        $this->company = $company;

        return $this;
    }

    /**
     * @return Collection|Friends[]
     */
    public function getFriendRequestSent(): Collection
    {
        return $this->friendRequestSent;
    }

    public function addFriendRequestSent(Friends $friendRequestSent): self
    {
        if (!$this->friendRequestSent->contains($friendRequestSent)) {
            $this->friendRequestSent[] = $friendRequestSent;
            $friendRequestSent->setSenderUser($this);
        }

        return $this;
    }

    public function removeFriendRequestSent(Friends $friendRequestSent): self
    {
        if ($this->friendRequestSent->removeElement($friendRequestSent)) {
            // set the owning side to null (unless already changed)
            if ($friendRequestSent->getSenderUser() === $this) {
                $friendRequestSent->setSenderUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Friends[]
     */
    public function getFriendRequestReceived(): Collection
    {
        return $this->friendRequestReceived;
    }

    public function addFriendRequestReceived(Friends $friendRequestReceived): self
    {
        if (!$this->friendRequestReceived->contains($friendRequestReceived)) {
            $this->friendRequestReceived[] = $friendRequestReceived;
            $friendRequestReceived->setReceiverUser($this);
        }

        return $this;
    }

    public function removeFriendRequestReceived(Friends $friendRequestReceived): self
    {
        if ($this->friendRequestReceived->removeElement($friendRequestReceived)) {
            // set the owning side to null (unless already changed)
            if ($friendRequestReceived->getReceiverUser() === $this) {
                $friendRequestReceived->setReceiverUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Post[]
     */
    public function getPostsId(): Collection
    {
        return $this->postsId;
    }

    public function addPostsId(Post $postsId): self
    {
        if (!$this->postsId->contains($postsId)) {
            $this->postsId[] = $postsId;
            $postsId->addUserId($this);
        }

        return $this;
    }

    public function removePostsId(Post $postsId): self
    {
        if ($this->postsId->removeElement($postsId)) {
            $postsId->removeUserId($this);
        }

        return $this;
    }

    /**
     * @return Collection|Remark[]
     */
    public function getRemarks(): Collection
    {
        return $this->remarks;
    }

    public function addRemark(Remark $remark): self
    {
        if (!$this->remarks->contains($remark)) {
            $this->remarks[] = $remark;
            $remark->addUserId($this);
        }

        return $this;
    }

    public function removeRemark(Remark $remark): self
    {
        if ($this->remarks->removeElement($remark)) {
            $remark->removeUserId($this);
        }

        return $this;
    }

    /**
     * @return Collection|ChallengesUserRegister[]
     */
    public function getChallengesUserRegister(): Collection
    {
        return $this->challengesUserRegister;
    }

    public function addChallengesUserRegister(ChallengesUserRegister $challengesUserRegister): self
    {
        if (!$this->challengesUserRegister->contains($challengesUserRegister)) {
            $this->challengesUserRegister[] = $challengesUserRegister;
            $challengesUserRegister->setUserRegister($this);
        }

        return $this;
    }

    public function removeChallengesUserRegister(ChallengesUserRegister $challengesUserRegister): self
    {
        if ($this->challengesUserRegister->removeElement($challengesUserRegister)) {
            // set the owning side to null (unless already changed)
            if ($challengesUserRegister->getUserRegister() === $this) {
                $challengesUserRegister->setUserRegister(null);
            }
        }

        return $this;
    }

    public function getFacebookId(): ?string
    {
        return $this->facebookId;
    }

    public function setFacebookId(?string $facebookId): self
    {
        $this->facebookId = $facebookId;

        return $this;
    }

    public function getGoogleId(): ?string
    {
        return $this->googleId;
    }

    public function setGoogleId(?string $googleId): self
    {
        $this->googleId = $googleId;

        return $this;
    }

    /*
     * @return Collection<int, Challenges>
     */
    public function getChallenges(): Collection
    {
        return $this->challenges;
    }

    public function getStatut(): ?bool
    {
        return $this->statut;
    }

    public function setStatut(bool $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->password,
            $this->username,
            $this->imageName,
        ));
    }

    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->password,
            $this->username,
            $this->imageName,
        ) = unserialize($serialized, array('allowed_classes' => false));
    }

    public function getInitials(): ?string
    {
        return $this->initials;
    }

    public function setInitials(string $initials): self
    {
        $this->initials = $initials;

        return $this;
    }
}
