<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
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
     * @ORM\Column(type="string", length=180, unique=true)
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
     * @ORM\ManyToMany(targetEntity=Challenges::class, inversedBy="users")
     */
    private $challenge;


    /**
     * @ORM\ManyToMany(targetEntity=Challenges::class, inversedBy="userRegister")
     * @ORM\JoinTable(name="challenge_register_user")
     */
    private $challengeRegister;

    /**
     * @ORM\ManyToMany(targetEntity=Post::class, mappedBy="usersWhoLiked")
     */
    private $likedPosts;


    /**
     * @ORM\OneToMany(targetEntity=Role::class, mappedBy="userId")
     */
    private $role;

    /**
     * @ORM\OneToMany(targetEntity=Statistical::class, mappedBy="userId")
     */
    private $statisticals;

    /**
     * @ORM\ManyToMany(targetEntity=Group::class, inversedBy="users")
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
     * @ORM\ManyToMany(targetEntity=Post::class, mappedBy="userId")
     */
    private $postsId;

    /**
     * @ORM\ManyToMany(targetEntity=Remark::class, mappedBy="userId")
     */
    private $remarks;

    public function __construct()
    {
        $this->ranks = new ArrayCollection();
        $this->challenge = new ArrayCollection();
        $this->likedPosts = new ArrayCollection();
        $this->likedRemarks = new ArrayCollection();
        $this->role = new ArrayCollection();
        $this->statisticals = new ArrayCollection();
        $this->idGroup = new ArrayCollection();
        $this->userLikeRemarks = new ArrayCollection();
        $this->userLikePosts = new ArrayCollection();
        $this->send_message = new ArrayCollection();
        $this->received_message = new ArrayCollection();
        $this->postsId = new ArrayCollection();
        $this->remarks = new ArrayCollection();
    }

    public function __toString()
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
     * @return Collection
     */
    public function getChallenge(): Collection
    {
        return $this->challenge;
    }

    public function addChallenge(Challenges $challenge): self
    {
        if (!$this->challenge->contains($challenge)) {
            $this->challenge[] = $challenge;
        }

        return $this;
    }

    public function removeChallenge(Challenges $challenge): self
    {
        $this->challenge->removeElement($challenge);

        return $this;
    }


    /**
     * @return Collection|Post[]
     */
    public function getLikedPosts(): Collection
    {
        return $this->likedPosts;
    }

    public function addLikedPost(Post $likedPost): self
    {
        if (!$this->likedPosts->contains($likedPost)) {
            $this->likedPosts[] = $likedPost;
            $likedPost->addUsersWhoLiked($this);
        }

        return $this;
    }

    public function removeLikedPost(Post $likedPost): self
    {
        if ($this->likedPosts->removeElement($likedPost)) {
            $likedPost->removeUsersWhoLiked($this);
        }

        return $this;
    }

    /**
     * @return Collection|Remark[]
     */
    public function getLikedRemarks(): Collection
    {
        return $this->likedRemarks;
    }

    public function addLikedRemark(Remark $likedRemark): self
    {
        if (!$this->likedRemarks->contains($likedRemark)) {
            $this->likedRemarks[] = $likedRemark;
            $likedRemark->addUserRemark($this);
        }

        return $this;
    }

    public function removeLikedRemark(Remark $likedRemark): self
    {
        if ($this->likedRemarks->removeElement($likedRemark)) {
            $likedRemark->removeUserRemark($this);
        }

        return $this;
    }

    /**
     * @return Collection|Role[]
     */
    public function getRole(): Collection
    {
        return $this->role;
    }

    public function addRole(Role $role): self
    {
        if (!$this->role->contains($role)) {
            $this->role[] = $role;
            $role->setUserId($this);
        }

        return $this;
    }

    public function removeRole(Role $role): self
    {
        if ($this->role->removeElement($role)) {
            // set the owning side to null (unless already changed)
            if ($role->getUserId() === $this) {
                $role->setUserId(null);
            }
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
}
